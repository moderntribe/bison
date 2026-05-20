<?php

use Carbon\Carbon;
use Carbon\Carbonite;

it('freezes time at a given moment', function () {
    Carbonite::freeze('2024-01-15 10:00:00');

    expect(Carbon::now()->toDateTimeString())->toBe('2024-01-15 10:00:00')
        ->and(Carbonite::speed())->toBe(0.0);
});

it('accelerates the fake timeline', function () {
    Carbonite::freeze('2024-01-01 00:00:00');
    Carbonite::speed(2);

    expect(Carbonite::accelerate(3))->toBe(6.0);
});

it('decelerates the fake timeline', function () {
    Carbonite::freeze('2024-01-01 00:00:00');
    Carbonite::speed(5);

    expect(Carbonite::decelerate(2))->toBe(2.5);
});

it('elapses time on the fake timeline', function () {
    Carbonite::freeze('2024-01-01');
    Carbonite::elapse('1 month');

    expect(Carbon::now()->format('Y-m-d'))->toBe('2024-02-01');
});

it('advances time with tick inside fakeAsync', function () {
    fakeAsync(function () {
        $now = Carbon::now();

        tick(2000);

        expect($now->diffForHumans())->toBe('2 seconds ago');
    });
});

it('sets timeline speed with speed()', function () {
    Carbonite::freeze('2024-06-01 12:00:00');
    Carbonite::speed(3);

    expect(Carbonite::speed())->toBe(3.0);
});
