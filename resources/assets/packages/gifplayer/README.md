Gifplayer
===========

Customizable jquery plugin to play and stop animated gifs. Similar to 9gag’s

### Install as a bower package

```bash
$ bower install gifplayer
```



### Basic usage

>When static image and gif have the same name.

```html
<img id="banana" src="img/banana.png" class="gifs">
```

>When static image and gif have different names.

```html
<img id="banana" src="img/banana.png" data-gif="img/banana_animated.gif" class="gifs">
```

```javascript
$(function () {
	$('.gifs').gifplayer();
});
```
