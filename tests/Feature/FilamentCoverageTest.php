<?php

declare(strict_types=1);

use Filament\Panel;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Liberu\Accounting\ThreeWayMatchingFilament\Resources\MatchRecordResource;
use Liberu\Accounting\ThreeWayMatchingFilament\Resources\Pages\ListMatches;
use Liberu\Accounting\ThreeWayMatchingFilament\ThreeWayMatchingFilamentPlugin;
use Liberu\Accounting\ThreeWayMatchingFilament\ThreeWayMatchingFilamentServiceProvider;

it('registers and configures accounting-three-way-matching-filament filament resources', function (): void {
    $provider = $this->app->register(ThreeWayMatchingFilamentServiceProvider::class, force: true);
    if (method_exists($provider, 'boot')) {
        $provider->boot();
    }
    expect($provider)->toBeInstanceOf(ThreeWayMatchingFilamentServiceProvider::class);
    $plugin = ThreeWayMatchingFilamentPlugin::make();
    $panel = Panel::make()->id('test-accounting-three-way-matching-filament');
    $plugin->register($panel);
    $plugin->boot($panel);
    expect($plugin->getId())->toBeString()->not->toBeEmpty();
    $host = new ListMatches();
    expect(MatchRecordResource::getPages())->toBeArray();
    expect(MatchRecordResource::form(Schema::make($host)))->toBeInstanceOf(Schema::class);
    expect(MatchRecordResource::table(Table::make($host)))->toBeInstanceOf(Table::class);
});
