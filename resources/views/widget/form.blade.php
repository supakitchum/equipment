<form {{ isset($id) ? 'id='.$id : '' }} action="{{ $action }}" method="{{ $method == "post" || $method == "get" ? $method : "post" }}">
    @csrf
    @if($method == 'put')
        @method('PUT')
    @elseif($method == 'delete')
        @method('DELETE')
    @endif
    @if(isset($grid) && $grid)
        <div class="row">
            @endif
            @foreach($elements as $element)
                @if($element["tag"] == "input")
                    @if(isset($element['col']))
                        <div class="{{ $element['col'] }}">
                            @endif
                            <div class="form-group">
                                <label
                                    for="{{ $element["id"] }}">{{ $element["label"] }} {!! isset($element["required"]) && $element["required"] ? '<span class="text-danger">(*)</span>' : '' !!}</label>
                                <input
                                    {{ isset($element["required"]) && $element["required"] ? 'required' : '' }}
                                    {{ isset($element["disabled"]) && $element["disabled"] ? 'disabled' : '' }}
                                    {{ isset($element["readonly"]) && $element["readonly"] ? 'readonly' : '' }}
                                    type="{{ $element["type"] }}"
                                    class="form-control{{ $errors->has($element["name"]) ? ' is-invalid' : '' }}"
                                    id="{{ $element["id"] }}"
                                    name="{{ $element["name"] }}"
                                    placeholder="{{ $element["placeholder"]?:'' }}"
                                    value="{{ old($element["name"]) ? old($element["name"]) : (isset($element['value']) ? $element['value'] : '') }}"
                                >
                                @if ($errors->has($element["name"]))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $errors->first($element["name"]) }}</strong>
                    </span>
                                @endif
                            </div>
                            @if(isset($element['col']))
                        </div>
                    @endif
                @elseif($element["tag"] == "select")
                    @if(isset($element['col']))
                        <div class="{{ $element['col'] }}">
                            @endif
                            <div class="form-group">
                                <label
                                    for="{{ $element["id"] }}">{{ $element["label"] }} {!! isset($element["required"]) && $element["required"] ? '<span class="text-danger">(*)</span>' : '' !!}</label>
                                <select
                                    {{ isset($element["required"]) && $element["required"] ? 'required' : '' }}
                                    {{ isset($element["disabled"]) && $element["disabled"] ? 'disabled' : '' }}
                                    {{ isset($element["readonly"]) && $element["readonly"] ? 'readonly' : '' }}
                                    class="form-control{{ $errors->has($element["name"]) ? ' is-invalid' : '' }}"
                                    style="height: 40px !important;"
                                    id="{{ $element["id"] }}"
                                    name="{{ $element["name"] }}"
                                >
                                    <option value="">กรุณาเลือก</option>
                                    @foreach($element["options"] as $option)
                                        <option
                                            {{ isset($element['value']) && $element['value'] == $option['value'] ? 'selected' : '' }} value="{{ $option['value'] }}">{{ $option['text'] }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has($element["name"]))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $errors->first($element["name"]) }}</strong>
                    </span>
                                @endif
                            </div>
                            @if(isset($element['col']))
                        </div>
                    @endif
                @elseif($element["tag"] == "textarea")
                    @if(isset($element['col']))
                        <div class="{{ $element['col'] }}">
                            @endif
                            <div class="form-group">
                                <label
                                    for="{{ $element["id"] }}">{{ $element["label"] }} {!! isset($element["required"]) && $element["required"] ? '<span class="text-danger">(*)</span>' : '' !!}</label>
                                <textarea
                                    {{ isset($element["required"]) && $element["required"] ? 'required' : '' }}
                                    {{ isset($element["disabled"]) && $element["disabled"] ? 'disabled' : '' }}
                                    {{ isset($element["readonly"]) && $element["readonly"] ? 'readonly' : '' }}
                                    class="form-control{{ $errors->has($element["name"]) ? ' is-invalid' : '' }}"
                                    id="{{ $element["id"] }}"
                                    name="{{ $element["name"] }}"
                                >{{ old($element["name"]) ? old($element["name"]) : (isset($element['value']) ? $element['value'] : '') }}</textarea>
                                @if ($errors->has($element["name"]))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                        <strong>{{ $errors->first($element["name"]) }}</strong>
                    </span>
                                @endif
                            </div>
                            @if(isset($element['col']))
                        </div>
                    @endif
                @endif
            @endforeach
            @if(isset($grid) && $grid)
        </div>
    @endif
    @if(!isset($button) || $button)
        <button type="submit" class="btn btn-success float-right w-100">ยืนยัน</button>
    @endif
</form>
