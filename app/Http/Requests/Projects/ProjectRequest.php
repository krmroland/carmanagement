<?php

namespace App\Http\Requests\Projects;

use App\Users\Models\User;
use Illuminate\Validation\Rule;
use App\Projects\Models\Project;
use App\Http\Requests\UniqueRule;
use App\Users\Models\Organization;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Authorizes this request
     * @return boolean
     */
    public function authorize()
    {
        $owner = $this->route('projectOwner');

        if ($owner instanceof Organization) {
            return $owner->gate()->authorize('projects.write');
        }

        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'currency' => 'required',
            'details' => 'array',
            'identifier' => 'sometimes|nullable',
            'total_cost' => 'numeric',
            'type' => ['required', Rule::in(Project::TYPES)],
        ];
    }
}
