<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Boolean;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Http\Requests\NovaRequest;
use Eminiarts\Tabs\Tabs;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Traits\HasTabs;
use Eminiarts\Tabs\Traits\HasActionsInTabs; // Add this Trait
use Marshmallow\AdvancedImage\AdvancedImage;
use Outl1ne\MultiselectField\Multiselect;

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
     * Build a "detail" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        /////////////////////---DO NOT DELETE---///////////////////////////////////////
        // $mollie = new \Mollie\Api\MollieApiClient();
        // $mollie->setApiKey("test_qNQvK877QFxW5trDJjM9A8WFaywyVt");

        // $methods = $mollie->methods->allActive();

        // $methods_array = [];
        // foreach ($methods as $method) {
        //     array_push($methods_array, $method->description);
        // }

        // $detail = $query->first();

        // $detail->org_paymethodes = json_encode($methods_array);

        // $detail->save();
        /////////////////////---DO NOT DELETE---///////////////////////////////////////

        return parent::detailQuery($request, $query);
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
     * The visual style used for the table. Available options are 'tight' and 'default'.
     *
     * @var string
     */
    public static $tableStyle = 'tight';

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
                    Text::make('Adres', 'org_adres')->hideFromIndex(),
                    Text::make('Postcode', 'org_postcode')->hideFromIndex(),
                    Text::make('Plaats', 'org_plaats'),

                    Text::make('Email', 'org_emailadres'),
                    Text::make('Website', 'org_website'),

                    Text::make('IBAN', 'org_iban')->hideFromIndex(),
                    Text::make('KVK', 'org_kvknr')->hideFromIndex(),
                    Text::make('BTW', 'org_btwnr')->hideFromIndex(),

                    AdvancedImage::make('Logo', 'org_logo')->disk('s3')->croppable(16 / 9)->disableDownload()->deletable(false),
                ]),
                Tab::make('Facturatie', [
                    Text::make('Naam', 'org_factnaam')->hideFromIndex(),
                    Text::make('Ter attentie van', 'org_facttav')->hideFromIndex(),
                    Text::make('Adres', 'org_factadres')->hideFromIndex(),
                    Text::make('Postcode', 'org_factpostcode')->hideFromIndex(),
                    Text::make('Plaats', 'org_factplaats')->hideFromIndex(),
                    Text::make('Emailadres', 'org_factemailadres')->hideFromIndex()->help('PS: ontvangt op dit adres onze maandelijkse digitale factuur (PDF)'),
                ]),
                Tab::make('Ticketshop instellingen', [
                    Boolean::make('Toon print service', 'org_onlinefact')
                        ->trueValue('Y')
                        ->falseValue('N')
                        ->hideFromIndex(),

                    Boolean::make('Niet printen melding', 'org_printservice')->help('(tbv barcodes scannen vanaf smartphones)')
                        ->trueValue('Y')
                        ->falseValue('N')
                        ->hideFromIndex(),

                    Boolean::make('Mail aankoopfactuur-link', 'org_dontprintnote')
                        ->trueValue('Y')
                        ->falseValue('N')
                        ->hideFromIndex(),
                ]),
                Tab::make('Mollie PSP', [
                    Text::make('PSP', function () {
                        return "Mollie";
                    })->hideFromIndex(),

                    Text::make('PSP website', function () {
                        return "<a style='color: blue;' href='https://www.mollie.com/nl'>www.mollie.com<a>";
                    })->asHtml()->hideFromIndex(),

                    Text::make('Live API-key', 'org_mollielive')->help("Je Mollie API-key kun je hier vinden: <a target='_blank' href='https://help.mollie.com/hc/nl/articles/115000328205-Waar-vind-ik-de-API-key-'>mollie</a>")
                        ->asHtml()
                        ->hideFromIndex(),

                    Text::make('Test API-key', 'org_mollietest')
                        ->hideFromIndex(),

                    Select::make('Status', 'org_paystatus')->options([
                        'live' => 'Live',
                        'test' => 'Test',
                    ])->hideFromIndex(),

                    Multiselect::make('Betaalmethodes', 'org_paymethodes')->options([
                        "ideal" => "Ideal",
                        "creditcard" => "Creditcard",
                        "paypal" => "Paypal",
                        'giropay' => "Giropay",
                    ])->help("Selecteer hier de betaalmethodes die je ook hebt bij <a target='_blank' href='https://www.mollie.com/nl/payments'>mollie</a>")
                        ->asHtml()
                        ->hideFromIndex(),

                    // Get the payment methods database inside mollie.

                    // Multiselect::make('Betaalmethodes', 'org_paymethodes')->options(function () {
                    //     return array_combine($this->org_paymethodes, $this->org_paymethodes);
                    // })->readonly(),
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
