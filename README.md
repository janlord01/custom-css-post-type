# Custom CSS Per Page WordPress Plugin

**Description:**

The Custom CSS Per Page WordPress Plugin allows you to add custom CSS to individual posts, pages, or custom post types directly from the WordPress admin. Easily manage and style specific pages without affecting the global styles.

**Features:**

- Add custom CSS to individual posts, pages, or any custom post types.
- Simple settings page to select which post types the custom CSS feature should be available for.
- Utilizes CodeMirror for a rich text editor experience with syntax highlighting and line numbers.
- Ensures that custom CSS is sanitized to prevent XSS vulnerabilities.
- Lightweight and performance-friendly.

**Installation:**

1. Upload the plugin files to the `/wp-content/plugins/custom-css-per-page` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to 'Settings' -> 'Custom CSS Settings' to select which post types you want to enable custom CSS for.
4. Edit any post or page, and you'll find a 'Custom CSS' meta box where you can add your custom CSS.

**Usage:**

1. Navigate to the settings page to choose which post types you want to support.
2. Add custom CSS to individual posts or pages through the provided meta box.
3. The custom CSS will only apply to the specific post or page, allowing for granular control over your site's styling.

**Example:**

Here is an example of how you might use custom HTML and CSS in a post:

```html
<!-- Custom HTML -->
<div class="custom-container">
    <h1>Custom Styled Header</h1>
    <p>This is a paragraph with custom styles applied.</p>
</div>

/* Custom CSS */
.custom-container {
    background-color: #f0f0f0;
    padding: 20px;
    border-radius: 10px;
}
.custom-container h1 {
    color: #333333;
    font-size: 2.5em;
}
.custom-container p {
    color: #666666;
    font-size: 1.2em;
}


License:
This plugin is licensed under the GPL2.

Author:
Janlord Luga