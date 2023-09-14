<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateWidgetRequest;
use App\Models\Widget;
use App\Repositories\WidgetRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Inertia\Response;
use Inertia\ResponseFactory;

class WidgetController extends Controller
{

    public Collection $widgets;

    public function __construct(WidgetRepository $repository)
    {
        $this->widgets = $repository->getQuery()->orderby('size', 'desc')->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response|ResponseFactory
    {
        return inertia('Widgets/Index')->with([
            'widgets' => $this->widgets,
        ]);
    }

    /**
     * @return \Inertia\Response|\Inertia\ResponseFactory|\Illuminate\Http\RedirectResponse
     */
    public function create(): Response|ResponseFactory|RedirectResponse
    {
        return inertia(
            'Widgets/CreateEdit'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateWidgetRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $widget = new Widget();
        $widget->size = $data['size'];
        $widget->save();

        return redirect()->route('widgets.index')->with(['message' => 'Created widget!']);
    }

    /**
     * @param \App\Models\Widget $widget
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory|\Illuminate\Http\RedirectResponse
     */
    public function edit(Widget $widget): Response|ResponseFactory|RedirectResponse
    {
        return inertia(
            'Widgets/CreateEdit', [
                'record' => $widget,
            ]
        );
    }

    public function update(StoreUpdateWidgetRequest $request, Widget $widget): RedirectResponse
    {
        $data = $request->validated();
        $widget->size = $data['size'];
        $widget->save();

        return redirect()->route('widgets.index')->with('message', 'Updated record');
    }

    public function destroy(Widget $widget): RedirectResponse
    {
        $widget->delete();

        return redirect()
            ->route('widgets.index')
            ->with('message', 'Record deleted!');
    }

}
