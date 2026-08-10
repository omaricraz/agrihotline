<?php

namespace App\Http\Controllers;

use App\Services\ComplaintImportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ComplaintImportController extends Controller
{
    public function create(): View
    {
        return view('complaints.import');
    }

    public function store(Request $request, ComplaintImportService $importService): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ]);

        $result = $importService->import(
            $request->file('file')->getRealPath(),
            $request->user()->id,
        );

        if ($result['imported'] === 0 && $result['errors'] !== []) {
            return back()
                ->withInput()
                ->with('error', 'Import failed. No complaints were imported.')
                ->with('import_errors', $result['errors']);
        }

        $message = "{$result['imported']} complaint(s) imported successfully.";

        if ($result['errors'] !== []) {
            return redirect()
                ->route('complaints.index')
                ->with('success', $message)
                ->with('import_errors', $result['errors']);
        }

        return redirect()
            ->route('complaints.index')
            ->with('success', $message);
    }

    public function template(ComplaintImportService $importService): StreamedResponse
    {
        return response()->streamDownload(function () use ($importService) {
            $importService->writeTemplateToStream(fopen('php://output', 'w'));
        }, 'complaints-import-template.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
