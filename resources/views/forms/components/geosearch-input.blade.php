<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="{
        state: @this.entangle('{{ $getStatePath() }}'),
        label() {
            return this.state ? this.state.label : ''
        },

        init() {
            let searchLabel = '{{ __('Search a location') }}';
            if (this.state) {
                searchLabel = this.state.label;
            }

            const map = L.map('{{ $getId() }}', {
                zoomControl: {{ $getZoomControl() }},
                scrollWheelZoom: {{ $getScrollWheelZoom() }}
            }).setView([0, 0], 0);

            L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            let defaultMarker = null;
            if (this.state) {
                const obj = (this.state);
                defaultMarker = L.marker([obj.y, obj.x]).addTo(map);
                map.setView([obj.y, obj.x], {{ $getZoomLevel() }});
            }

            const provider = new GeoSearch.{{ $getProvider() }}Provider({
                params: {
                  access_token: '{{ $getApiKey() }}'
                }
            });
            const search = new GeoSearch.GeoSearchControl({
                provider: provider,
                autoComplete: {{ $getAutoComplete() }},
                autoCompleteDelay: {{ $getAutoCompleteDelay() }},
                style: '{{ $getStyle() }}',
                showMarker: true,
                maxMarker: 1,
                marker: {
                    draggable: false,
                },
                autoClose: true,
                retainZoomLevel: false,
                maxSuggestions: 5,
                keepResult: true,
                searchLabel: searchLabel,
                resultFormat: function(t) {
                    return '' + t.result.label;
                },
                updateMap: true
            });
            map.addControl(search);

            const that = this;

            map.on('geosearch/showlocation', function(location) {
                that.state = location.location;
                if (defaultMarker) {
                    map.removeLayer(defaultMarker);
                    defaultMarker = null;
                }
            });
        }
    }">
        <span x-text="label()" class="font-bold text-sm"></span>
        <div id="{{ $getId() }}" style="height: {{$getMapHeight()}}px; z-index: 0;" class="w-full rounded-lg shadow-sm" wire:ignore></div>

        @push('scripts')
            @if($isViewRecord())
                <style>
                    .leaflet-control-geosearch {
                        display: none;
                    }
                </style>
            @endif
        @endpush
    </div>
</x-forms::field-wrapper>
