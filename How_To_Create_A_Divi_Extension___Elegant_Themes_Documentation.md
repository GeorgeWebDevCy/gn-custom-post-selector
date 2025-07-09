## Developer Documentation

**Search Documentation**

**DIVI EXTRA BLOOM MONARCH DIVI BUILDER DEVELOPERS**

```
BACK TO DEVELOPER DOCUMENTATION
```
###### Divi Changes Everything. Save 50% With Divi Pro Give It A Test Drive!When You Join Today! LEARN MOREGET DIVI


## How To Create A Divi Builder Module

###### Learn how to create a custom module for the Divi Builder.

### Custom Divi Builder Modules

###### Divi Builder modules consist of PHP, JavaScript, HTML, & CSS code. Each module is defined using a PHP class. The class

###### defines all of the module’s settings and is responsible for rendering the module’s HTML output on the frontend.

###### Additionally, each module has a ReactJS component class (in JavaScript) that handles rendering the module inside of

###### the Divi Builder. In this tutorial, you’ll learn how to create a custom header module. The module will be fully functional

###### in the builder, both on the frontend and on the backend.

###### Custom Divi Builder modules must be implemented within a theme, child-theme, or Divi Extension. In this tutorial we’re

###### going to implement a custom module in a Divi Extension. If you haven’t already done so, go ahead and create a Divi

###### Extension.

### Module Definition

#### Note: This tutorial series is intended for advanced users. At least a basic

#### understanding of coding in PHP and JavaScript is required.

# “

###### Divi Changes Everything. Save 50% With Divi Pro Give It A Test Drive!When You Join Today! LEARN MOREGET DIVI


```
view raw
```
###### Divi Builder modules are defined using a PHP class. Look inside your extension’s directory and find the example module

###### located in includes/modules. We’ll use it as a starting point to create a custom header module. First, let’s rename the

###### HelloWorld directory to SimpleHeader. Next, rename HelloWorld.php to SimpleHeader.php , open it, and then edit it as

###### shown below:

```
SimpleHeader.php hosted with ❤ by GitHub
```
```
1 <?php
2
3 class SIMP_SimpleHeader extends ET_Builder_Module {
4
5 public $slug = 'simp_simple_header';
6 public $vb_support = 'on';
7
8 public function init() {
9 $this->name = esc_html__( 'Simple Header', 'simp-simple-extension' );
10 }
11
12 public function get_fields() {
13 return array();
14 }
15
16 public function render( $unprocessed_props, $content, $render_slug ) {
17
18 }
19 }
20
21 new SIMP_SimpleHeader;
```
###### Divi Changes Everything. Save 50% With Divi Pro Give It A Test Drive!When You Join Today! LEARN MOREGET DIVI


###### Our module will include just a few basic settings that can be controlled from within the Divi Builder: heading, content,

###### and background. Module settings are defined in the get_fields() method. Let’s go ahead and do that now:

```
1 <?php
2
3 class SIMP_SimpleHeader extends ET_Builder_Module {
4
5 public $slug = 'simp_simple_header';
6 public $vb_support = 'on';
7
8 public function init() {
9 $this->name = esc_html__( 'Simple Header', 'simp-simple-extension' );
10 }
11
12 public function get_fields() {
13 return array(
14 'heading' => array(
15 'label' => esc_html__( 'Heading', 'simp-simple-extension' ),
16 'type' => 'text',
17 'option_category' => 'basic_option',
18 'description' => esc_html__( 'Input your desired heading here.', 'simp-simple-extension' ),
19 'toggle_slug' => 'main_content',
20 ),
21 'content' => array(
22 'label' => esc_html__( 'Content', 'simp-simple-extension' ),
23 'type' => 'tiny_mce',
24 'option_category' => 'basic_option',
25 'description' => esc_html__( 'Content entered here will appear below the heading text.', 's
26 'toggle_slug' => 'main_content',
27 ),
```
###### Divi Changes Everything. Save 50% With Divi Pro Give It A Test Drive!When You Join Today! LEARN MOREGET DIVI


```
SimpleHeader.php hosted with ❤ by GitHub view raw
```
###### You probably noticed that the background field is missing. We excluded it from the fields array because it’s one of

###### several advanced fields that are added automatically by the builder to all modules unless they specifically opt-out. You’ll

###### learn more about advanced fields a bit later in this tutorial series.

###### Our module definition is almost complete. We just need to finish the implementation of the render() method so that it

###### will generate the module’s HTML output based on its props. Ready? Let’s do it!

```
28 );
29 }
30
31 public function render( $unprocessed_props, $content, $render_slug ) {
32
33 }
34 }
35
36 new SIMP_SimpleHeader;
```
```
1 <?php
2
3 class SIMP_SimpleHeader extends ET_Builder_Module {
4
5 public $slug = 'simp_simple_header';
6 public $vb_support = 'on';
7
8 public function init() {
9 $this->name = esc_html__( 'Simple Header', 'simp-simple-extension' );
```
###### Divi Changes Everything. Save 50% With Divi Pro Give It A Test Drive!When You Join Today! LEARN MOREGET DIVI


10 }
11
12 public function get_fields() {
13 return array(
14 'heading' => array(
15 'label' => esc_html__( 'Heading', 'simp-simple-extension' ),
16 'type' => 'text',
17 'option_category' => 'basic_option',
18 'description' => esc_html__( 'Input your desired heading here.', 'simp-simple-extension' ),
19 'toggle_slug' => 'main_content',
20 ),
21 'content' => array(
22 'label' => esc_html__( 'Content', 'simp-simple-extension' ),
23 'type' => 'tiny_mce',
24 'option_category' => 'basic_option',
25 'description' => esc_html__( 'Content entered here will appear below the heading text.', 's
26 'toggle_slug' => 'main_content',
27 ),
28 );
29 }
30
31 public function render( $unprocessed_props, $content, $render_slug ) {
32 return sprintf(
33 '<h1 class="simp-simple-header-heading">%1$s</h1>
34 <p>%2$s</p>',
35 esc_html( $this->props['heading'] ),
36 $this->props['content']
37 );
38 }
39 }
40
41 new SIMP_SimpleHeader;

###### Divi Changes Everything. Save 50% With Divi Pro Give It A Test Drive!When You Join Today! LEARN MOREGET DIVI


```
SimpleHeader.php hosted with ❤ by GitHub view raw
```
### React Component

###### In order for our module to be available and fully functional inside the Divi Builder we must create a React Component

###### class that handles the rendering of our module based on its props. Look in your module’s directory for the file named

###### HelloWorld.jsx.

###### Let’s rename HelloWorld.jsx to SimpleHeader.jsx , open it, and then edit it as follows:

#### Note: JSX is a syntax extension to JavaScript used in React to describe what

#### the UI should look like.

# “

```
1 // External Dependencies
2 import React, { Component, Fragment } from 'react';
3
4 // Internal Dependencies
5 import './style.css';
6
7
8 class SimpleHeader extends Component {
9
10 static slug = 'simp_simple_header';
```
###### Divi Changes Everything. Save 50% With Divi Pro Give It A Test Drive!When You Join Today! LEARN MOREGET DIVI


```
view raw
```
```
view raw
```
```
SimpleHeader.jsx hosted with ❤ by GitHub
```
###### Next, let’s update the import and export statements in includes/modules/index.js :

```
index.js hosted with ❤ by GitHub
```
###### Now, let’s edit the render() method and make it produce the same output that we defined in our PHP render() method.

```
11
12 render() {
13 return (
14 <div className="simp-simple-header">
15 {this.props.content()}
16 </div>
17 );
18 }
19 }
20
21 export default SimpleHeader;
```
```
1 // Internal Dependencies
2 import SimpleHeader from './SimpleHeader/SimpleHeader';
3
4 export default [
5 SimpleHeader,
6 ];
```
```
1 // External Dependencies
2 import React, { Component, Fragment } from 'react';
3
```
###### Divi Changes Everything. Save 50% With Divi Pro Give It A Test Drive!When You Join Today! LEARN MOREGET DIVI


```
SimpleHeader.jsx hosted with ❤ by GitHub view raw
```
###### There are two things in our render() method to take note of. First, note how the module’s content setting is handled.

###### Module settings defined with field type tiny_mce (like the content setting in our module) require the use of a special

###### React Component. The builder sets up the required component and then passes it down to the module as the setting

###### value. Since the value is not a string or number and is actually a React Component, we need to use it as such in our JSX

###### markup.

```
4 // Internal Dependencies
5 import './style.css';
6
7
8 class SimpleHeader extends Component {
9
10 static slug = 'simp_simple_header';
11
12 render() {
13 return (
14 <Fragment>
15 <h1 className="simp-simple-header-heading">{this.props.heading}</h1>
16 <p>
17 {this.props.content()}
18 </p>
19 </Fragment>
20 );
21 }
22 }
23
24 export default SimpleHeader;
```
###### Divi Changes Everything. Save 50% With Divi Pro Give It A Test Drive!When You Join Today! LEARN MOREGET DIVI


```
view raw
```
###### Also note how we wrapped our module’s output in a Fragment component. Fragments allow you to return multiple top-

###### level elements from your render() method without actually adding an extra element to the page itself.

### CSS Styles

###### Styles for our module can be defined using the style.css file in its directory. Our custom header module is pretty basic so

###### it doesn’t require much styling. Though we should add some bottom margin for the heading so that there is some space

###### between it and the content below it. Later, in our Divi Builder Module In-Depth tutorial series you’ll learn how to make

###### margin and padding for the heading (or any element inside your module’s output) configurable from within the module’s

###### settings.

###### For now, let’s go ahead and update our module’s style.css :

```
style.css hosted with ❤ by GitHub
```
### Testing During Development

###### Before we can test our custom module in the Divi Builder we need to compile the JSX code into regular JavaScript. To

###### do that, simply run the following command inside your plugin’s directory:

```
1 .simp-simple-header-heading {
2 margin-bottom: 20 px;
3 }
```
###### Divi Changes Everything. Save 50% With Divi Pro Give It A Test Drive!When You Join Today! LEARN MOREGET DIVI


```
yarn start
```
###### Provided there are no syntax errors in your code you will see the following output:

###### Now you can launch the Divi Builder and check out your Simple Header module!

#### Note: You must keep the terminal window with yarn start running open while

#### you are developing your module. As you make changes to the files, the

#### JavaScript and CSS will be recompiled automatically.

# “

###### Divi Changes Everything. Save 50% With Divi Pro Give It A Test Drive!When You Join Today! LEARN MOREGET DIVI


**156k 75k 64k 325k 188k 6k**

## 974,872 Customers Are Already Building Amazing

## Websites With Divi. Join The Most Empowered

## WordPress Community On The Web

SIGN UP TODAY

##### We offer a 30 Day Money Back Guarantee, so joining is Risk-Free!

###### Divi Changes Everything. Save 50% With Divi Pro Give It A Test Drive!When You Join Today! LEARN MOREGET DIVI


Followers Members Followers Subscribers Subscribers Followers

**DIVI FEATURES**

Divi Modules

Divi Layouts

No-Code Builder

Workflow

Ecommerce Websites

Theme Builder

Marketing Platform

Speed & Performance

Developers

Premium Support

```
PRODUCTS
```
Divi Theme

Divi Marketplace

Divi Cloud

Divi AI

Divi Teams

Divi VIP

Divi Hosting

Divi Dash

Extra Theme

Bloom Plugin

Monarch Plugin

```
RESOURCES
```
Documentation

Help Articles & FAQ

24/7 Support

Developer Docs

System Status

```
BLOG
```
Recent Posts

Product Updates

Divi Resources

Business

WordPress

Best Plugins

Top Tools

Best Hosting

```
COMMUNITY
```
Divi Meetups

Divi Facebook Group

Divi Examples

Divi Integrations

Divi Reviews

Community Forum

Affiliate Program

**COMPANY**

About Us

Careers

Contact Us

Terms of Service

All Features

Quick Sites

Plans & Pricing

###### Divi Changes Everything. Save 50% With Divi Pro Give It A Test Drive!When You Join Today! LEARN MOREGET DIVI


Privacy Policy

###### Copyright © 2025 Elegant Themes ®

###### Divi Changes Everything. Save 50% With Divi Pro Give It A Test Drive!When You Join Today! LEARN MOREGET DIVI


