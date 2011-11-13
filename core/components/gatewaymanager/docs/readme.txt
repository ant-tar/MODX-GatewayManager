--------------------
GatewayManager
--------------------
Version: 1.0.0-pl
Since: November 13th, 2011
Author: Bert Oost <bertoost85@gmail.com> at OostDesign.nl

With the GatewayManager you're able to make your contexts available
for certain context inside your MODX installation. You even can
link a resource as new startpage and the GatewayManager provides a
placeholder with the original URL (useful for canonical tags)


Example useage
--------------------

The GatewayManager for MODX Revolution is configured to be running
automatically. When installing it trough the Package Manager you
don't need to do anything except setting up the domeins. The 
GatewayManager will be available below the Components menu item.

If you wanna use the canonical tag, you can use this tag to create
it completely automatic.

[[!+gateway.canonical:notempty=`<link rel="canonical" href="[[+gateway.canonical]]" />`]]