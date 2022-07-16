<?php

namespace App\Nova;

use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\PasswordConfirmation;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Hidden;
use Illuminate\Validation\Rules;

// use Illuminate\Validation\Rules;

class User extends Resource
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
            return $query->where('u_orgid', $request->user()->u_orgid);
        }
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'email';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'email', 'u_emailadres'
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
            Text::make('Gebruikersnaam', 'u_username')
                ->sortable()
                ->rules('required', 'max:255')
                ->showOnPreview(),

            Text::make('Naam', 'u_realname')
                ->sortable()
                ->rules('required', 'max:255')
                ->showOnPreview(),

            Text::make("organisatie", function () {
                if (isset($this->organisations->org_naam)) {
                    return $this->organisations->org_naam;
                }
                return "organisatie niet gevonden";
            })->sortable(),

            Text::make("Email", "email")
                ->hideFromIndex()
                ->rules('required', 'email', 'max:100')
                ->creationRules('unique:users')
                ->sortable(),

            Password::make('Password', "password")
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:6')
                ->updateRules('nullable', 'string', 'min:6'),

            PasswordConfirmation::make('Password Confirmation')
                ->onlyOnForms()
                ->rules('required_with:password', 'same:password'),

            Select::make('Geslacht', 'u_sexe')->options([
                'man' => 'Man',
                'vrouw' => 'Vrouw',
                '-' => '-',
            ])->withMeta(['value' => '-'])
                ->hideFromIndex(),

            Hidden::make('Role', 'role')->default(function () {
                return 'organisator';
            }),

            Hidden::make('OrgID', 'u_orgid')->default(function ($request) {
                return $request->user()->u_orgid;
            }),

            Hidden::make('OrgID', 'u_rights')->default(function () {
                return "a:2:{s:9:'dashboard';s:1:'Y';s:7:'scannen';s:1:'Y';}";
            }),

            Hidden::make('OrgID', 'u_scantype')->default(function () {
                return "administrator";
            }),
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
