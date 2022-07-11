<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\PasswordConfirmation;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\BelongsToMany;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Hidden;

use League\Flysystem\AwsS3V3\PortableVisibilityConverter;

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
        if($request->user()->role == 'admin') {
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
    public static $title = 'u_id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        // 'id', 'name', 'email',
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
            Text::make('Username' , 'u_realname')
            ->sortable()
            ->rules('required', 'max:255')
            ->showOnPreview(),

            Text::make("organisatie", function () {
                if(isset($this->organisations->org_naam)) {
                    return $this->organisations->org_naam;
                }

                return "organisatie niet gevonden";
            })->sortable(),

            Text::make("Email", "u_emailadres")->sortable(),
            Text::make("Login Email", "email")->sortable(),

            Password::make('Password', "password")
                ->onlyOnForms(),
            // ->creationRules('required', Rules\Password::defaults(), 'confirmed')
            // ->updateRules('nullable', Rules\Password::defaults(), 'confirmed'),

            PasswordConfirmation::make('Password Confirmation', "password"),

            Select::make('Role', 'role')->options([
                'organisator' => 'Organisator',
                'vrijwilleger' => 'Vrijwilleger',
            ]),

            Hidden::make('OrgID', 'u_orgid')->default(function ($request) {
                return $request->user()->u_orgid;
            })

            // Image::make('Email')->disableDownload()->disk('s3'),

            // Text::make('Email')
            //     ->sortable()
            //     ->rules('required', 'email', 'max:254')
            //     ->creationRules('unique:users,email')
            //     ->updateRules('unique:users,email,{{resourceId}}'),

            // Password::make('Password')
            //     ->onlyOnForms()
            //     ->creationRules('required', Rules\Password::defaults())
            //     ->updateRules('nullable', Rules\Password::defaults()),
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
