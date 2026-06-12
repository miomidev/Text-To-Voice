<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MasterQuizController extends Controller
{
    /**
     * Show the Master Quiz TTS generator page.
     */
    public function index()
    {
        return view('master-quiz.index');
    }

    /**
     * Generate TTS audio using edge-tts Python library.
     * Uses a JSON config file to pass arguments — avoids Windows shell % escaping issues.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'text'  => 'required|string|max:1000',
            'voice' => 'required|string|in:id-ID-ArdiNeural,id-ID-GadisNeural,en-US-GuyNeural,en-US-ChristopherNeural',
            'rate'  => 'nullable|string',
            'pitch' => 'nullable|string',
        ]);

        $text  = $request->input('text');
        $voice = $request->input('voice', 'id-ID-ArdiNeural');
        $rate  = $request->input('rate', '+0%');
        $pitch = $request->input('pitch', '+0Hz');

        // Validate rate format: must be like +0%, -10%, +25%
        if (!preg_match('/^[+\-]\d+%$/', $rate)) {
            $rate = '+0%';
        }

        // Validate pitch format: must be like +0Hz, -10Hz, +5Hz
        if (!preg_match('/^[+\-]\d+Hz$/', $pitch)) {
            $pitch = '+0Hz';
        }

        // Create unique output filename
        $filename   = 'mq_' . Str::uuid() . '.mp3';
        $outputDir  = storage_path('app/public/master-quiz');
        $outputPath = $outputDir . DIRECTORY_SEPARATOR . $filename;

        // Ensure output directory exists
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        // Write config to a temp JSON file to avoid Windows shell escaping issues
        // (% character in rate/pitch breaks exec() on Windows CMD/PowerShell)
        $configPath = storage_path('app/master-quiz-config-' . Str::uuid() . '.json');
        $config = [
            'text'   => $text,
            'voice'  => $voice,
            'rate'   => $rate,
            'pitch'  => $pitch,
            'output' => $outputPath,
        ];
        file_put_contents($configPath, json_encode($config, JSON_UNESCAPED_UNICODE));

        // Path to our Python helper script
        $scriptPath = storage_path('app/master_quiz_tts.py');

        // Build command — only file paths as arguments, no special characters
        $escapedScript = escapeshellarg($scriptPath);
        $escapedConfig = escapeshellarg($configPath);
        $command = "python {$escapedScript} {$escapedConfig} 2>&1";

        $output     = [];
        $returnCode = 0;
        exec($command, $output, $returnCode);

        // Clean up temp config file
        @unlink($configPath);

        if ($returnCode !== 0 || !file_exists($outputPath)) {
            $errorMsg = implode("\n", $output);
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate audio. Error: ' . $errorMsg,
            ], 500);
        }

        // Clean up old files (older than 1 hour) to keep storage lean
        $this->cleanupOldFiles($outputDir);

        // Return the public URL
        $publicUrl = asset('storage/master-quiz/' . $filename);

        return response()->json([
            'success'  => true,
            'url'      => $publicUrl,
            'filename' => $filename,
        ]);
    }

    /**
     * Download the generated audio file.
     */
    public function download(Request $request)
    {
        $request->validate([
            'filename' => 'required|string|regex:/^mq_[a-f0-9\-]+\.mp3$/',
        ]);

        $filename = $request->input('filename');
        $path = storage_path('app/public/master-quiz/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        return response()->download($path, 'master-quiz-audio.mp3', [
            'Content-Type' => 'audio/mpeg',
        ]);
    }

    /**
     * Remove audio files older than 1 hour.
     */
    private function cleanupOldFiles(string $dir): void
    {
        if (!is_dir($dir)) return;

        $files = glob($dir . DIRECTORY_SEPARATOR . 'mq_*.mp3');
        $oneHourAgo = time() - 3600;

        foreach ($files as $file) {
            if (is_file($file) && filemtime($file) < $oneHourAgo) {
                @unlink($file);
            }
        }
    }
}
