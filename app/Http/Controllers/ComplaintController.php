<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComplaintRequest;
use App\Models\Complaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    public function index(Request $request): View
    {
        $complaints = Complaint::query()
            ->with('creator')
            ->search($request->query('q'))
            ->dateRange($request->query('start_date'), $request->query('end_date'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('complaints.index', compact('complaints'));
    }

    public function create(): View
    {
        return view('complaints.create');
    }

    public function store(StoreComplaintRequest $request): RedirectResponse
    {
        Complaint::create([
            ...$request->validated(),
            'status' => 'new',
            'created_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('complaints.index')
            ->with('success', 'Complaint logged successfully.');
    }

    public function show(Complaint $complaint): View
    {
        $complaint->load('creator');

        return view('complaints.show', compact('complaint'));
    }

    public function updateStatus(Request $request, Complaint $complaint): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(config('complaints.statuses')))],
        ]);

        $complaint->update($data);

        return back()->with('success', 'Complaint status updated.');
    }
}
