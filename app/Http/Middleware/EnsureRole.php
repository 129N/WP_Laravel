// app/Http/Middleware/EnsureRole.php

<?php



use Closure;
use Illuminate\Http\Request;

class EnsureRole 
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($request->user()?->role !== $role) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        return $next($request);
    }
}
