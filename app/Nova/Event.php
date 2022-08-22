<?php

namespace App\Nova;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class Event extends Resource
{
    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->role == 'admin') {
            return $query;
        } else {
            return $query->where('event_orgid', $request->user()->u_orgid);
        }
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Event::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'event_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'event_name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make("Event Name", "event_name")->sortable(),
            Trix::make("Event Description", "event_description")->sortable(),

            Boolean::make("Enabled in shop", "event_visibleinshop")
                ->trueValue('Y')
                ->falseValue('N')
                ->sortable(),

            Boolean::make("Visible on site", "event_visibleonsite")
                ->trueValue('Y')
                ->falseValue('N')
                ->sortable(),

            Boolean::make("Enabled", "event_enabled")
                ->trueValue('Y')
                ->falseValue('N')
                ->sortable(),

            Select::make('Type', 'event_type')->options([
                'concert' => 'Concert',
                'conferentie' => 'Conferentie',
                'evenement' => 'Evenement',
                'fair' => 'Fair',
                'festival' => 'Festival',
                'film' => 'Film',
                'onderwijs' => 'Onderwijs',
                'party' => 'Party',
                'seminar' => 'Seminar',
                'show' => 'Show',
                'sport' => 'Sport',
                'theater' => 'Theater',
                'workshop' => 'Workshop',
            ]),

            Text::make('Genre', 'event_genre'),

            Hidden::make('event_orgid', function () {
                return auth()->user()->u_orgid;
            }),

            HasMany::make("Entrees", "entrees"),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
