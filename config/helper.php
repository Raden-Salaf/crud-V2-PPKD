<?php

// function = sebuah fungsi untuk melakukan query berulang

function getStatus(int $status): string
{
    return $status ? '<span class="badge text-bg-succes bg-success text-dark">Active</span>' : '<span class="badge text-bg-warning bg-warning">Inactive</span>';
}

function getLabel($status)
{
    switch ($status) {
        case '1':
            return '<span class="badge bg-primary">Active</span>';
            break;

        default:
            return '<span class="badge bg-danger">In active</span>';
            break;
    }
}

function inputFailed($status,)
{
    return "  <span class='text-danger'>$status</span>";
}
