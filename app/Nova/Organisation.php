<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Image;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Http\Requests\NovaRequest;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Traits\HasTabs;
use Eminiarts\Tabs\Traits\HasActionsInTabs; // Add this Trait
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Panel;

class Organisation extends Resource
{
    use HasTabs;
    use HasActionsInTabs;

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
            return $query->where('org_orgid', $request->user()->u_orgid);
        }
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Organisation::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [];

    public static function searchable()
    {
        return false;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Tabs::make('Organisatie Instellingen', [
                Tab::make('Gegevens organisatie', [
                    Text::make('Organisatie', 'org_naam'),
                    Text::make('Adres', 'org_adres'),
                    Text::make('Postcode', 'org_postcode'),
                    Text::make('Plaats', 'org_plaats'),

                    Text::make('Email', 'org_emailadres'),
                    Text::make('Website', 'org_website'),

                    Text::make('IBAN', 'org_iban')->hideFromIndex(),
                    Text::make('KVK', 'org_kvknr')->hideFromIndex(),
                    Text::make('BTW', 'org_btwnr')->hideFromIndex(),

                    Image::make('Logo', 'org_logo')
                        ->disk('s3')
                        ->disableDownload(),
                ]),
                Tab::make('Facturatie', [
                    Text::make('Adres', 'org_adres')
                    // Naam
                    // Ter attentie van	
                    // Adres
                    // Postcode	
                    // Plaats
                    // Emailadres
                ]),
                Tab::make('Ticketshop instellingen', [
                    Text::make('Adres', 'org_adres')
                    // Toon print service
                    // Niet printen melding
                    // Mail aankoopfactuur-link	
                ]),
                Tab::make('Mollie PSP', [
                    Text::make('Adres', 'org_adres')
                    // PSP	
                    // PSP website
                    // Merchant ID	
                    // Status
                    // Betaalmethodes
                ]),
                Tab::make('Gebruikers', [
                    HasMany::make('users'),
                ]),
            ])->withToolbar(),
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
