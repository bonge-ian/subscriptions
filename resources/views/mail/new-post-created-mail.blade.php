<x-mail::message>
# Hello {{ $username }}

Good news.

One of your subscriptions [{{ $site_title }}]({{ $site_url }}) has recently published a new post.

Below is the summary of the new post

<x-mail::panel>
## {{ $post_title }}

{{ $post_body }}
</x-mail::panel>

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
