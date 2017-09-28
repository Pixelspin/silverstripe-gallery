<h1>$Title</h1>
$Content
<% loop $Items %>
    <h2>$Title</h2>
    <% if $Type == 'Image' %>
        $Image
    <% else %>
        <img src="$VideoImageURL" />
        <iframe src="$VideoEmbedURL"></iframe>
    <% end_if %>
<% end_loop %>