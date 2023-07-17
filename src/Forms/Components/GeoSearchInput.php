<?php

namespace Rhukster\FilamentGeoSearch\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\ViewRecord;

class GeoSearchInput extends Field
{
    protected string $view = 'filament-geosearch::forms.components.geosearch-input';

    protected int $mapHeight = 200;
    protected bool $zoomControl = true;
    protected bool $scrollWheelZoom = true;
    protected int $zoomLevel = 10;
    protected string $provider = 'OpenStreetMap';
    protected string $apiKey = '';
    protected string $style = 'bar';
    protected bool $autoComplete = true;
    protected int $autoCompleteDelay = 250;

    public function getAutoComplete(): string
    {
        return $this->autoComplete ? 'true' : 'false';
    }

    public function setAutoComplete(bool $autoComplete): static
    {
        $this->autoComplete = $autoComplete;
        return $this;
    }

    public function getAutoCompleteDelay(): int
    {
        return $this->autoCompleteDelay;
    }

    public function setAutoCompleteDelay(int $autoCompleteDelay): static
    {
        $this->autoCompleteDelay = $autoCompleteDelay;
        return $this;
    }

    public function getStyle(): string
    {
        return $this->style;
    }

    public function setStyle(string $style): static
    {
        $this->style = $style;
        return $this;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): static
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }

    public function setProvider(string $provider): static
    {
        $this->provider = $provider;
        return $this;
    }

    public function setMapHeight(int $mapHeight): static
    {
        $this->mapHeight = $mapHeight;
        return $this;
    }

    public function getMapHeight(): int
    {
        return $this->mapHeight;
    }

    public function getZoomControl(): string
    {
        return $this->zoomControl ? 'true' : 'false';
    }

    public function setZoomControl(bool $zoomControl): static
    {
        $this->zoomControl = $zoomControl;
        return $this;
    }

    public function getScrollWheelZoom(): string
    {
        return $this->scrollWheelZoom ? 'true' : 'false';
    }

    public function setScrollWheelZoom(bool $scrollWheelZoom): static
    {
        $this->scrollWheelZoom = $scrollWheelZoom;
        return $this;
    }

    public function setZoomLevel(int $zoomLevel): static
    {
        $this->zoomLevel = $zoomLevel;
        return $this;
    }

    public function getZoomLevel(): int
    {
        return $this->zoomLevel;
    }

    public function isViewRecord(): bool {
        return $this->getLivewire() instanceof ViewRecord;
    }

    public function getMapId(): string {
        return str_replace('.', '-', $this->getId()) . '-map';
    }
}
