<?php

it('has demo page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
