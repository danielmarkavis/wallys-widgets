<?php

namespace App\Http\Controllers;

use App\Http\Requests\PackingWidgetRequest;
use App\Repositories\WidgetRepository;
use App\Services\WidgetServiceInterface;
use Inertia\Response;
use Inertia\ResponseFactory;

class PackingController extends Controller
{

    public array $widgets = [];

    public function __construct(WidgetRepository $repository)
    {
        $this->widgets = collect($repository->getQuery()->orderby('size', 'desc')->get())->toArray();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response|ResponseFactory
    {
        return inertia('Packing/Index')->with([
            'widgets' => $this->widgets,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackingWidgetRequest $request, WidgetServiceInterface $widgetService, WidgetRepository $repository): Response|ResponseFactory
    {
        $data = $request->validated();

        $quantity = $data['quantity'];
        $packs = collect($repository->getQuery()->orderby('size', 'desc')->get())->pluck('size')->toArray();

        $order = $widgetService->setPacks($packs)->execute($quantity, $data['optimize']);
        $actualQuantity = 0;

        foreach($order as $index => $item) {
            $actualQuantity += floor($index * $item);
        }

        return inertia('Packing/Index')->with([
            'order'   => $order,
            'widgets' => $this->widgets,
            'actualQuantity' => $actualQuantity
        ]);
    }

}
