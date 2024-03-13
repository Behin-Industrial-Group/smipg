@if (auth()->user()->access('Show Agency Simfa Info'))
@php
    $tab_name = "foreman";
@endphp
@isset(config("agency_info.customer_type.$customer_type->value")[$tab_name])
    <div class="tab-pane fade show" id="{{$tab_name}}" role="tabpanel" aria-labelledby="{{$tab_name}}-info">
        <form action="javascript:void(0)" id="simfa-form">
            <input type="hidden" name="id" id="" value="{{ $customer_type->id ?? '' }}">
            <table class="table table-striped ">
                @foreach (config("agency_info.customer_type.$customer_type->value")[$tab_name] as $field_key => $field_detail)
                    @php
                        $value = $agency_fields->where('key', $field_key)->first()?->value;
                    @endphp
                    <tr>
                        <td>
                            {{ __($field_key) }}
                        </td>
                        <td>
                            {{ $HtmlCreator::createInput($field_key, $field_detail, $value) }}
                        </td>
                    </tr>
                @endforeach
            </table>
            <button class="btn btn-primary" onclick="{{$tab_name}}_edit()">{{ __('Edit') }}</button>
        </form>
    </div>
@endisset

@endif