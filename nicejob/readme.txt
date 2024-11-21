=== NiceJob ===
Contributors: nicejob
Tags: nicejob, showroom, trust badge, review, marketing
Requires at least: 3.0.1
Requires PHP: 7.0
Tested up to: 6.7
Stable tag: 3.7.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily add NiceJob Stories, Reviews, and Engage to your Wordpress site.

== Description ==

Easily add NiceJob stories, reviews, trust badge, engage to your Wordpress site.

== Installation ==

1. Upload the nicejob-for-wordpress plugin into your WordPress site, activate it.

2. A new NiceJob menu will appear on the admin sidebar menu.

3. Copy your Company ID from NiceJob company profile page, and paste it on to the field.

4. Save the Company ID, it will be automatically used in the shortcode.

5. How to use shortcode:
   * [nicejob-stories]
       * style: [grid/single] layout style (optional, default is grid)
       * show: [all/photos/reviews/reviews-no-photos] stories to show (default is all)
       * max-height: stories maximum height (optional, default none)
       * branding: [top/bottom] brand position (optional, default top)
       * source: [account,{company_id},{company_id}...] Show stories from all the companies in a account, a few companies (comma separate).  (optional, default: current company)
       Example usage of complete options:
       [nicejob-stories style=&quot;grid&quot; show=&quot;reviews&quot; max-height=300 branding=&quot;bottom&quot; source=&quot;account&quot;]
   * [nicejob-badge]
       * show-reviews: [1/0] Show reviews
       * source: [account,{company_id},{company_id}...] Show reviews from all the companies in a account, a few companies (comma separate).  (optional, default: current company)
       Example usage of complete options:
       [nicejob-badge show-reviews=&quot;1&quot; source=&quot;account&quot;]
   * [nicejob-engage]
       * positions: [left/right] Position on screen
       * event-types: [Booking,Review] Events to show (comma separated)
       * mobile: [show/hide] Show or hide on mobile device (optional), default: show
       Example usage of complete options:
       [nicejob-engage position=&quot;left&quot; event-types=&quot;Booking,Review&quot;]
   * [nicejob-lead]
       * type: [a/button] anchor link or button, default: a
       * class: additional element class (optional)
       * text: element text, default: Click here for an estimate
       Example usage of complete options:
       [nicejob-lead type=&quot;button&quot; class=&quot;button-right button-blue&quot; text=&quot;Click here for an estimate&quot;]
       If you already add one of above widgets, you can make a lead button anywhere by adding element class nj-lead to an anchor or button element, it will automatically enable that button to open lead form.
   * [nicejob-review]
       * type: [a/button] anchor link or button, default: a
       * class: additional element class (optional)
       * text: element text, default: Leave us a review!
       Example usage of complete options:
       [nicejob-review type=&quot;button&quot; class=&quot;button-right button-blue&quot; text=&quot;Leave us a review!&quot;]
       If you already add one of above widgets, you can make a review button anywhere by adding element class nj-review to an anchor or button element, it will automatically enable that button to open review form.
   * [nicejob-recommendation]
        * type: [a/button] anchor link or button, default: a
        * class: additional element class (optional)
        * text: element text, default: Recommend us!
        Example usage of complete options:
        [nicejob-recommendation type="button" class="button-right button-blue" text="Recommend us around you!"]

== Screenshots ==

1. Stories with reviews
2. Reviews only
3. Stories only
4. Trust badge
5. Engage
6. Usage

== Changelog ==

= 3.6.5 = 
* Fixed escaping dynamic attributes

= 3.6.4 =
* Patch security vulnerabilities

= 3.6.1 =
* Tested up to WordPress 6.5.3 to ensure compatibility.

= 3.6.0 =
* Add source attribute to trust badge & stories shortcode

= 3.5.0 =
* Add shortcode for NiceJob recommendations

= 3.4.1 =
* Update default value for engage shortcode button
* Update default value for stories shortcode button

= 3.4 =
* Update readme

= 3.3 =
* Added new shortcode for collect reviews

= 3.2 =
* Bug fixes
* Added new shortcode for collect leads

= 3.1 =
* Added new shortcode for engage

= 3.0 =
* Add admin menu to fill in Company ID
* Automatically using Company ID
* Added rich editor NiceJob button

= 2.2 =
* Add trust badge

= 2.1 =
* Use company hash instead of id for more secure
* Shortcode can still using id, no changes on user side

= 2.0 =
* Introduced new shortcode for stories
* Deprecate old shortcodes
* Existing old shortcodes still works

= 1.0 =
* Add shortcode for NiceJob showroom
* Add shortcode for NiceJob review feed
