<?php

it('displays the welcome page', function () {
    $this->get('/')
        ->assertSuccessful()
        ->assertViewIs('welcome');
});
