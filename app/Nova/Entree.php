<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\DateTime;
use Marshmallow\AdvancedImage\AdvancedImage;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Traits\HasTabs;
use Eminiarts\Tabs\Traits\HasActionsInTabs; // Add this Trait
use Laravel\Nova\Http\Requests\NovaRequest;

class Entree extends Resource
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
            return $query->where('entree_orgid', $request->user()->u_orgid);
        }
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Entree::class;

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
    public static $search = [
        'id',
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
            Tabs::make('Organisatie Instellingen', [
                Tab::make('Entree', [
                    Text::make("Titel", "entree_title")->sortable(),
                    Text::make("Sub Titel", "entree_subtitle")->sortable(),
                    DateTime::make('Entree Sale Start', 'entree_salestart'),
                    DateTime::make('Entree Sale End', 'entree_saleend'),

                    // Relationships:
                    BelongsTo::make('Event', 'event'),

                ]),
                Tab::make('Ticketshop', [
                    AdvancedImage::make('Foto', 'entree_foto')->disk('s3')->croppable()->disableDownload()->deletable(false)->hideFromIndex(),

                ]),
                Tab::make('Earlybird', [
                    Boolean::make('Enabled', 'entree_enabled')
                        ->trueValue('Y')
                        ->falseValue('N'),
                ]),
                Tab::make('Coupon / vouchers', [
                    Boolean::make('Enabled', 'entree_enabled')
                        ->trueValue('Y')
                        ->falseValue('N'),
                ]),
                Tab::make('Status', [
                    Boolean::make('Enabled', 'entree_enabled')
                        ->trueValue('Y')
                        ->falseValue('N'),
                ]),
                Tab::make('Ticket opmaak', [
                    AdvancedImage::make('Tickethead', 'entree_tickethead')->disk('s3')->croppable()->disableDownload()->deletable(false),
                    AdvancedImage::make('Banner 1', 'entree_bannerone')->disk('s3')->croppable()->disableDownload()->deletable(false),
                    AdvancedImage::make('Banner 2', 'entree_bannertwo')->disk('s3')->croppable()->disableDownload()->deletable(false),
                ]),

                Tab::make('Gekochte tickets', [
                    HasMany::make("Ticketdatas", "ticketdatas"),
                ]),
            ])->withToolbar(),



            // entree_enabled
            // entree_orgid
            // entree_eventid
            // entree_type
            // entree_tickettype
            // entree_salestart
            // entree_saleend 
            // entree_startdate 
            // entree_enddate   
            // entree_showtime
            // entree_title
            // entree_subtitle  
            // entree_alerttext
            // entree_capacity        
            // entree_reserveermodus   
            // entree_order 
            // entree_prices    
            // entree_visible           
            // entree_servicekosten 
            // entree_transactiekosten
            // entree_mininput  
            // entree_maxinput
            // entree_regioid   
            // entree_locid 
            // entree_couponids 
            // entree_usercleaned   
            // entree_foto    
            // entree_tickethead    
            // entree_bannerone 
            // entree_bannertwo 
            // entree_closed    
            // entree_cancelled 
            // entree_soldout
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
        return [
            new Filters\EntreeType,
        ];
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
