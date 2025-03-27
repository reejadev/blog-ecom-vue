<?php

namespace App\Http\Controllers;

use App\Services\HeyzineService;
use Illuminate\Http\Request;

class FlipbookController extends Controller
{
    protected $heyzineService;

    public function __construct(HeyzineService $heyzineService)
    {
        $this->heyzineService = $heyzineService;
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf', // Example validation
        ]);

        $file = $request->file('file');
        $filePath = $file->getPathname();

        $result = $this->heyzineService->uploadFile($filePath);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 500);
        }

        return response()->json($result);
    }
}