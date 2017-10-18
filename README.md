# itaps

Tired of waiting for dead electronic taplists to come shambling back from the dead? Don't want to pay a ton of money for a rather simple product that simply manages a list of beers, kegs, and taps? Me too.

When I built my keezer, I really wanted an electronic display for my taps, because I am a major tech nerd. So, I search around and discovered Raspberry Pints. One RPi purchase later, I was up and running. However, things have changed, like the BJCP style categories. I also felt the back end could be improved.

So, after several weeks of coding in my spare time: iTaps Alpha 0.1.

You can run this on any web server running the LAMP stack and the Bootstrap framework. RPis are awesome for this, but by no means required. I develop on a Mac and run this on an RPi 3 stuck to the back of a monitor at my house. I am running the latest versions on my development machine and RPi.

My next step is to optimize the admin for mobile device display.

Some caveats:

Yes, this lacks some of the features of Raspberry Pints. If you just want something simple, iTaps is for you, otherwise stick with Raspberry Pints, as you can still get help with it at Homebrew Talk, http://www.homebrewtalk.com/showthread.php?t=487694.

This is still a beta release; it's working pretty well overall, but I am still cleaning up code and moving things about.

Yes, no flow meters. I'm really a front end designer, with coding nerds under my command for getting the back side of things working quickly. Since this is a personal project, it's just me. There are some coding languages and scripts that I am having to learn to make this all work as I'd like it. I don't have flowmeters in my keezer; they are expensive. Once I can afford flow meters, I'll incorporate them. 

At the moment, you will need to be comfortable with the command line, I have not done anything with auto setup files. You will need to install the LAMP stack, create a database, and import the SQL tables. It will be a while before I take the time to work up auto config files.

There is no security layer yet, if you leave this open to the world, someone can change all your data. I will eventually add this in, but it is really meant to be run on a local network behind a firewall.

This is really just a pet project born out of frustration. I know many others have done the same thing using even simpler options.

Where this is going (future plans):

DONE: Bootstrap 4

DONE: Mobile device display optimization

Login for admin section

Flow meters

DONE: Ability to import beers from brewing software (Beer Smith, Brewers Friend)

DONE: Improved form validation
