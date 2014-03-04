# Meet My Team #
**Contributors:** Buooy  
**Tags:** meet,my,team,members,staff,gallery,responsive,modal,grid  
**Requires at least:** 3.6  
**Tested up to:** 3.8.1  
**Stable tag:** 1.0.0  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

Ever needed to display a lot of team members but you find it too lengthy to put into a single page? Meet My Team solves that problem by providing an intuitive interface that allows you to add your team members and display their information in a responsive grid and modal! Sounds great?

## Description ##
Ever needed to display a lot of team members but you find it too lengthy to put into a single page? 

Meet My Team solves that problem by providing an intuitive interface that allows you to add your team members and display their information in a modal! Sounds great?

**Features**:  
1. Responsive Grid with Smooth Readjustments - We modified the bootstrap grid's naming convention so that it doesnt conflict with your bootstrap theme.

2. Responsive Modal Display - We utilised the well tested Reveal Modal from Zurb Foundation to build a responsive display of your individual theme.
Reveal Modal : http://zurb.com/playground/reveal-modal-plugin

3. Theme Agnostic - We implemented a minimal css strategy so that the plugin will fit in with any theme that you utilize.

4. Easy Styling Classes - We provided simple style classes that theme developers can use to target and style their own. More information about this coming

5. Insert into any page with our shortcode

**Supported Fields**  
1. Team Member Name

2. Team Member Profile Picture

3. Team Member Email

4. Team Member Biography

5. Team Member Personal URL e.g. Facebook, Linkedin

... More Coming

## Installation ##

### Using The WordPress Dashboard ###

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'Meet My Team'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

### Uploading in WordPress Dashboard ###

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `meet-my-team.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

### Using FTP ###

1. Download `meet-my-team.zip`
2. Extract the `meet-my-team` directory to your computer
3. Upload the `meet-my-team` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard


## Frequently Asked Questions ##

### How Do I Use The Plugin? ###

You can use it simply with this shortcode: [meet-my-team]

### What Shortcodes Are Available ###

We are currently working on a few, but as of now, we support the use of two options:

1. [meet-my-team cols="NUM"] where NUM can be 1,2,3,4,6. Default: 3
- cols will list out the number of cols of team members will be displayed in each row.

2. [meet-my-team parent_container_id="ID"] where ID can be the id of the overall container encapsulating the modals
- This is utilized more for theme developers who want to target the specific classes

### What responsive grid are you using ###

We are actually using a modified version of bootstrap. It was designed to shrink to a single column from 768px and below. More options in the future.

### Something is broken? Want a particular feature? ###

Feel free to email us at ahoy@buooy.com.

## Changelog ##

### 1.0 ###
* Introduction to Meet My Team

## Upgrade Notice ##

None as of now