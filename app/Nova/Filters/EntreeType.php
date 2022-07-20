<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\Log;
use \App\Models\Event;

class EntreeType extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query->where('entree_eventid', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        if ($request->user()->role === 'admin') {
            return Event::all()->mapWithKeys(fn ($item) => [$item->event_name => $item->event_id])->toArray();
        } else {
            $event = Event::where('event_orgid', $request->user()->u_orgid)->get();
            return $event->mapWithKeys(fn ($item) => [$item->event_name => $item->event_id])->toArray();
        }
    }
}
