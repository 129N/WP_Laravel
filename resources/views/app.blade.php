<!-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @routes
        @viteReactRefresh
        @vite(['resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia

        bbjkbkbb
    </body>
</html> -->
<!doctype html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name','Laravel API') }}</title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; margin: 2rem; }
    code { background: #f5f5f5; padding: .2rem .4rem; border-radius: 4px; }
    a { text-decoration: none; }
  </style>
</head>
<body>
  <h1>Waypoint Tracker API</h1>
  <p>Server is running.</p>
  <ul>
    <li><a href="{{ url('/api/ping') }}">/api/ping</a></li>
    <li><a href="{{ url('/api/status') }}">/api/status</a></li>
    <li><a href="{{ url('/api/registered_users') }}">/api/registered_users</a></li>
    <li><a href="{{ url('/api/user') }}">/api/user</a></li>
      <li><a href="{{ url('/api/waypoints') }}">/api/waypoints</a></li>
    
                    
  </ul>
</body>
</html>
