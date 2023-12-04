<?php

namespace Mys\percobaan\MVC\Model;

class UpdatePasswordRequest
{
    public ?string $id = null;
    public ?string $OldPassword = null;
    public ?string $NewPassword = null;
}