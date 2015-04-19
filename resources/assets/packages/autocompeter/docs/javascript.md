# The Javascript

## Regular download

You can either download the javascript code and put it into your own site
or you can leave it to Autocompeter to host it on its CDN (backed by
AWS CloudFront). To download, go to:

[**https://raw.githubusercontent.com/peterbe/autocompeter/master/public/dist/autocompeter.min.js**](https://raw.githubusercontent.com/peterbe/autocompeter/master/public/dist/autocompeter.min.js)

This is the optimized version. If you want to, you can download [the
non-minified file](https://raw.githubusercontent.com/peterbe/autocompeter/master/public/dist/autocompeter.js) instead which is easier to debug or hack on.

## Bower

You can use [Bower](http://bower.io/) to download the code too.
This will only install the files in a local directory called
`bower_components`. This is how you download and install with Bower:

    bower install autocompeter
    ls bower_components/autocompeter/public/dist/

It's up to you if you leave it there or if you copy those files where you
prefer them to be.

## Hosted

To use our CDN the URL is:

[http://cdn.jsdelivr.net/autocompeter/1/autocompeter.min.js](http://cdn.jsdelivr.net/autocompeter/1/autocompeter.min.js) (or [https version](https://cdn.jsdelivr.net/autocompeter/1/autocompeter.min.js))

But it's recommended that when you insert this URL into your site, instead
of prefixing it with `http://` or `https://` prefix it with just `//`. E.g.
like this:

    <script src="//cdn.jsdelivr.net/autocompeter/1/autocompeter.min.js"></script>

If you want to use a more specific version on the
[jsdelivr.net CDN](http://www.jsdelivr.com/) with more aggressive cache headers
then go to [http://www.jsdelivr.com/#!autocompeter](http://www.jsdelivr.com/#!autocompeter)
and pick up the latest version.

## Configure the Javascript

### Basics

So, for the widget to work you need to have an `<input type="text">` field
somewhere. You can put an attributes you like on it like `name="something"`
or `class="mysearch"` for example. But you need to be able to retrieve it as
a HTML DOM node because when you activate `Autocompeter` the first and only
required argument is the input DOM node. For example:

    <script>
    Autocompeter(document.getElementByClass('mysearch')[0]);
    </script>

or...

    <script>
    Autocompeter(document.querySelector('input.mysearch'));
    </script>

### Custom domain

By default it uses the domain that is currently being used. It retrieves this
by simply using `window.location.host`. If you for example, have a dev or
staging version of your site but you want to use the production domain, you
can manually set the domain like this:

    <script>
    Autocompeter(document.querySelector('input.mysearch'), {
      domain: 'example.com'
    });
    </script>

### Number of results to display

There are a couple of other options you can override. For example the
maximum number of items to be returned. The default is 10.:

    <script>
    Autocompeter(document.querySelector('input.mysearch'), {
      domain: 'example.com',
      number: 20
    });
    </script>

### Limiting results by 'groups'

Another thing you might want to set is the `groups` parameter. Note that
this can be an array or a comma separated string. Suppose that this information
is set by the server-side rendering, you can use it like this for example,
assuming here some server-side template rendering code like Django or Jinja
for example:

    <script>
    var groups = [];
    {% if user.is_logged_in %}
    groups.push('private');
    {% if user.is_admin %}
    groups.push('admins');
    {% endif %}
    {% endif %}
    Autocompeter(document.querySelector('input.mysearch'), {
      domain: 'example.com',
      number: 20,
      groups: groups
    });
    </script>

So, suppose you set `groups: "private,admins"` it will still search on titles
that were defined with no group. Doing it like this will just return
potentially more titles.

### Send a 'ping' first

For the web performance freaks.

Oftentimes the slowest part of a web service is DNS. The best way to avoid
that is to "warm up" the connection between users of your site and
`autocompeter.com`. This includes a first DNS lookup, the SSL certificate
negotiation and just making a TCP connection.

As soon as your user puts focus in the search widget you have
configured a ping is sent to `https://autocompeter.com/v1/ping` and basically
does nothing but it does prepare the connection for that first typing in
of the first character which starts the first autocomplete search.

This feature is enabled by default, to undo it set it to false like this:

    <script>
    Autocompeter(document.querySelector('input.mysearch'), {
      ping: false
    });
    </script>
