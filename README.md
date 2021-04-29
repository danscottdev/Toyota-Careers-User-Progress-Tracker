# Toyota-Careers-User-Progress-Tracker

For Toyota’s new 2021 “Drive to Employment” program, I built out a fully-custom progress-tracking system for registered users. With the broader site being built upon WordPress and utilizing an existing “membership” third-party plugin, I built in additional functionality that tracks and saves user progress as they advance through various sections of the site. Also added functionality to allow registered users to ‘bookmark’ pages, posts, and videos to their profile page for later viewing.

To accomplish this I created a simple plugin, which uses the JavaScript fetch() API on the front end to interact with custom-built REST API endpoints on the WordPress backend, and then saves custom data in the WordPress 'user_metadata' database table. The 'save progress' checkpoints are embeddable in the front-end via shortcode, making it easy for the non-technical client to customize their placement.

Major Concepts used:
  - JS IntersectionObserver() API
  - JS Fetch() API
  - REST API
  - Custom database entries
  - WordPress shortcodes