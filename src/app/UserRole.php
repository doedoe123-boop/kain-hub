<?php

namespace App;

enum UserRole: string
{
    case Admin = 'admin';
    case StoreOwner = 'store_owner';
    case Customer = 'customer';
}
