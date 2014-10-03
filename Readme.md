BadSec
-----

Getting started?

Managing this Code (basic git control skip if you know this)
-----
- Download [Git](http://git-scm.com/downloads/)
- `cd` into this directory and `git init .` (If you are using windows make sure you use git bash)
- Add your `git remote` for this repository. To do this make sure you have [ssh deploy enabled](https://confluence.atlassian.com/display/BITBUCKET/Set+up+SSH+for+Git)
- Almost there! `git pull origin master`
Notes: You'll want to learn `git` very well if you haven't already. It plays a big part of this set up, but is also applicable to any computer science class/ project you work on in the future. It's also industry standard.

Getting your environment running (If you're running some form of Debian, chances are you can skip this if you want)
-----
- Download [Vagrant](https://www.vagrantup.com/downloads.html). Go grab some tea while you wait.
- Make sure you're in the devbox directory and `vagrant up`. The first time you do this it'll take a while; pour yourself some more tea.
- Done? `vagrant ssh` password is `vagrant`

Getting the site running
-----
- Change your host file so that `injection.testing.postmodern.technology`,`serverside.testing.postmodern.technology` point to `10.10.10.10` if vagrant and just `localhost` if otherwise. Read how to [here](http://www.howtogeek.com/howto/27350/beginner-geek-how-to-edit-your-hosts-file/)
- Run `setup -v` if you installed vagrant. Yup that stands for 'setup vagrant'.
- Run `setup -d` otherwise. Yup that stands for 'setup dev'.
- Good to go? run `./toolbelt -ad`. This should take awhile. Don't worry. Still have some more tea?

Awesome. Now you're cranking.

Troubleshooting
-----
- If for some reason it hasn't worked, run `./toolbelt -d`. There's a chance the database didn't finish initializing.
- Another weird reason for it not working is the conversion of unix to windows line endings. This problem sounds pretty weird [but it is legit](http://stackoverflow.com/questions/14219092/bash-my-script-bin-bashm-bad-interpreter-no-such-file-or-directory). Thankfully there's a tool called `dos2unix` which you can install on your vagrant box using `sudo apt-get install dos2unix` run `dos2unix filename` to fix your worries. Note, I think it does something funky to file permissions. Just [make sure no weird file permissions git track into git](http://stackoverflow.com/questions/1580596/how-do-i-make-git-ignore-file-mode-chmod-changes).
- Is it really bad? See the notes on the `forgetitall` function and reseting your database down below. Send me (DM) an email if it gets to crazy levels of bad contact@dylanmadisetti.com
- Uploads for wordpress don't work? All ajax reponses and any response request for that matter get crunked up by existing php errors. Comment out the debug conditional in wp-config if you don't want these errors to pop up OR fix the php errors.

Are you golden? Alright, now what?
-----
- Get hacking

-----

Also...

If you play with the dev box, I would highly recommend learning how to `docker`. Failing that, if docker takes up too much disk space or you feel like you messed something up, run `./toolbelt -x`. This is the `fuckitall` method. It should kill everything docker related.

-----

Crunked up your local database?

Even though we do weekly backups, don't do whatever you did live. Stop your containers (`./toolbelt -s`) delete the folder `mysql` in `database/` and try running `toolbelt -d` again.