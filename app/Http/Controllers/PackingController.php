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
        $this->widgets = collect($repository->getQuery()->orderby('size', 'desc')->get())->pluck('size')->toArray();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(): Response|ResponseFactory
    {
        return inertia('Packing/Index')
            ->with([
                'widgets' => $this->widgets,
            ]);
    }

    /**
     * This would actually store the order in the DB, but instead I am just returning it in an inertia response.
     *
     * @param \App\Http\Requests\PackingWidgetRequest $request
     * @param \App\Services\WidgetServiceInterface    $widgetService
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function store(PackingWidgetRequest $request, WidgetServiceInterface $widgetService): Response|ResponseFactory
    {
        $data = $request->validated();

        $quantity = $data['quantity'];

        $order = $widgetService
            ->setPacks($this->widgets)
            ->execute($quantity, $data['optimize']);

        $actualQuantity = 0; // This section could be included in the execute command.
        foreach ($order as $index => $item) {
            $actualQuantity += floor($index * $item);
        }

        return inertia('Packing/Index')
            ->with([
                'order'          => $order,
                'widgets'        => $this->widgets,
                'actualQuantity' => $actualQuantity,
            ]);
    }

}
