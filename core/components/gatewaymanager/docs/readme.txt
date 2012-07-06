--------------------
GatewayManager
--------------------
Author: Bert Oost at OostDesign.nl <bert@oostdesign.nl>

With the GatewayManager you're able to make your domains available
for certain context inside your MODX installation. You even can
link a resource as new startpage and the GatewayManager provides a
placeholder with the original URL (useful for canonical tags)


Example useage
--------------------

The GatewayManager for MODX Revolution is configured to be running
automatically. When installing it trough the Package Manager you
don't need to do anything except setting up the domains. The 
GatewayManager will be available below the Components menu item.

If you wanna use the canonical tag, you can use this tag to create
it completely automatic.

[[!+gateway.canonical:notempty=`<link rel="canonical" href="[[+gateway.canonical]]" />`]]

Notice: to handle multiple domains your domains should point all to 
the same directory (of where MODX is installed). This is generally 
done with DNS but within your hosting this could be different. When 
you're unsure contact your hosting about it. When the domains not 
all pointing to the same directory the GatewayManager will not work.