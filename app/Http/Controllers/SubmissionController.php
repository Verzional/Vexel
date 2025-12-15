<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Rubric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Smalot\PdfParser\Parser;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::with('assignment')->latest()->get();
        return view('main.submissions.index', compact('submissions'));
    }

    public function create()
    {
        $assignments = Assignment::all();
        $rubrics = Rubric::all();
        return view('main.submissions.create', compact('assignments', 'rubrics'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'pdf_files'     => 'required|array|min:1',
            'pdf_files.*'   => 'mimes:pdf|max:10240',
            'assignment_id' => 'required|exists:assignments,id',
            'rubric_id'     => 'required|exists:rubrics,id',
            'student_name'  => 'nullable|string',
        ]);

        $name = $request->input('student_name', 'Anonymous');
        $parser = new Parser();

        // Ambil Data
        $selectedRubric = Rubric::find($request->rubric_id);
        $rubricData = $selectedRubric ? $selectedRubric->criteria : []; 

        $assignment = Assignment::find($request->assignment_id);
        $lastSubmissionId = null;

        foreach ($request->file('pdf_files') as $file) {
            $path = $file->store('submissions');
            try {
                $pdf = $parser->parseFile(storage_path('app/' . $path));
                $studentText = $pdf->getText();
            } catch (\Exception $e) {
                $studentText = "Gagal membaca teks PDF.";
            }

            // Panggil Fungsi Gemini
            $aiResult = $this->askGemini($assignment, $rubricData, $studentText);

            $finalContent = "=== HASIL PENILAIAN AI (GEMINI) ===\n\n" . $aiResult . "\n\n" . 
                            "==========================\n" .
                            "=== TEKS ASLI MAHASISWA ===\n" . $studentText;

            $submission = Submission::create([
                'assignment_id'  => $request->assignment_id,
                'student_name'   => $name,
                'file_path'      => $path,
                'extracted_text' => $finalContent,
            ]);

            $lastSubmissionId = $submission->id;
        }

        if ($lastSubmissionId) {
            return redirect()->route('submissions.show', $lastSubmissionId)
                             ->with('success', 'Analysis Complete!');
        }

        return redirect()->route('submissions.index');
    }

    /**
     * Fungsi Helper: Mengirim Request ke Google Gemini dengan AUTO-DEBUG
     */
    private function askGemini($assignment, $rubricJson, $studentText)
    {
        $apiKey = env('GEMINI_API_KEY'); 

        if (!$apiKey) return "Error: GEMINI_API_KEY belum disetting di .env";

        if (is_array($rubricJson) || is_object($rubricJson)) {
            $rubricJson = json_encode($rubricJson, JSON_PRETTY_PRINT);
        }

        $studentTextSafe = substr($studentText, 0, 15000); 

        $prompt = "
        Bertindaklah sebagai dosen. Nilai tugas ini berdasarkan rubrik.
        
        Judul: {$assignment->title}
        Deskripsi: {$assignment->description}

        Kriteria Rubrik:
        $rubricJson

        Jawaban Mahasiswa:
        $studentTextSafe

        Instruksi:
        1. Nilai per poin kriteria.
        2. Beri Nilai Akhir (0-100).
        3. Beri Feedback singkat bahasa Indonesia.
        ";

        // URL Model Utama: Gemini 1.5 Flash (Standar Baru)
        $model = 'gemini-2.5-flash'; 
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . $apiKey;

        try {
            $response = Http::post($url, [
                "contents" => [
                    [ "parts" => [ ["text" => $prompt] ] ]
                ]
            ]);

            if ($response->successful()) {
                if(isset($response->json()['candidates'][0]['content']['parts'][0]['text'])) {
                     return $response->json()['candidates'][0]['content']['parts'][0]['text'];
                } else {
                     return "Gemini Response Kosong: " . json_encode($response->json());
                }
            } else {
                // === LOGIKA DEBUG OTOMATIS ===
                // Jika error 404 (Model Not Found), kita coba tanya API: "Model apa yang tersedia untuk saya?"
                if ($response->status() == 404) {
                    $listModelsUrl = "https://generativelanguage.googleapis.com/v1beta/models?key=" . $apiKey;
                    $listResponse = Http::get($listModelsUrl);
                    
                    if ($listResponse->successful()) {
                        $models = $listResponse->json()['models'] ?? [];
                        $availableModels = array_map(function($m) { return str_replace('models/', '', $m['name']); }, $models);
                        $modelListString = implode(', ', $availableModels);
                        
                        return "ERROR: Model '$model' tidak ditemukan. \n\nDaftar Model yang tersedia untuk API Key Anda: \n[" . $modelListString . "]";
                    }
                }
                
                return "Gemini API Error ({$response->status()}): " . $response->body();
            }
        } catch (\Exception $e) {
            return "Connection Error: " . $e->getMessage();
        }
    }
    
    // ... Fungsi show, edit, update, destroy, download (Biarkan sama) ...
    
    public function show(Submission $submission)
    {
        $submission->load('assignment');
        return view('main.submissions.show', compact('submission'));
    }

    public function edit(Submission $submission)
    {
        $assignments = Assignment::all();
        return view('main.submissions.edit', compact('submission', 'assignments'));
    }

    public function update(Request $request, Submission $submission)
    {
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'student_name' => 'required|string',
            'file' => 'nullable|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('file')) {
            if ($submission->file_path && Storage::exists($submission->file_path)) {
                Storage::delete($submission->file_path);
            }
            $path = $request->file('file')->store('submissions');
            $parser = new Parser();
            try {
                $pdf = $parser->parseFile(storage_path('app/' . $path));
                $text = $pdf->getText();
            } catch (\Exception $e) {
                $text = "";
            }
            $submission->file_path = $path;
            $submission->extracted_text = $text; 
        }
        $submission->assignment_id = $request->assignment_id;
        $submission->student_name = $request->student_name;
        $submission->save();
        return redirect()->route('submissions.index')->with('success', 'Submission updated.');
    }

    public function destroy(Submission $submission)
    {
        if ($submission->file_path && Storage::exists($submission->file_path)) {
            Storage::delete($submission->file_path);
        }
        $submission->delete();
        return redirect()->route('submissions.index')->with('success', 'Deleted.');
    }

    public function download(Submission $submission)
    {
        $path = storage_path('app/' . $submission->file_path);
        if (!file_exists($path)) abort(404);
        return response()->download($path, basename($submission->file_path));
    }
}