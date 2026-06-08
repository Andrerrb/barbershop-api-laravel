<x-mail::message>
# New scheduling created

A new barbershop scheduling has been registered.

**Client:** {{ $scheduling->client->user->name }}

**Date:** {{ $scheduling->start_date->format('d/m/Y') }}

**Start time:** {{ $scheduling->start_date->format('H:i') }}

**End time:** {{ $scheduling->end_date->format('H:i') }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>