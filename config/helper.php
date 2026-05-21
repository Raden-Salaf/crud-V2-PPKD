<?php

// function = sebuah fungsi untuk melakukan query berulang

function getStatus(int $status): string
{
    return $status ? '<span class="badge text-bg-succes bg-success text-dark">Active</span>' : '<span class="badge text-bg-warning bg-warning">Inactive</span>';
}
