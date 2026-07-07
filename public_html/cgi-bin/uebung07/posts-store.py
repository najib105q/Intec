#!/usr/bin/env python3
# -*- coding: ascii -*-

import cgi
import cgitb
import json
import os
import datetime

cgitb.enable()

try:
    os.makedirs('posts', exist_ok=True)
except OSError:
    print("Content-Type: text/html; charset=ascii\n")
    print("<html><body><h1>Fehler</h1>")
    print("<p>Das Verzeichnis 'posts' konnte nicht erstellt werden. Bitte Berechtigungen pruefen.</p>")
    print("</body></html>")
    exit()

form = cgi.FieldStorage()

title = form.getvalue('title')
content = form.getvalue('content')
tags_raw = form.getvalue('tags')

if not title or not content or tags_raw is None:
    print("Content-Type: text/html; charset=ascii\n")
    print("<html><body><h1>Fehler</h1>")
    print("<p>Titel, Content und Tags duerfen nicht leer sein.</p>")
    print("</body></html>")
else:
    now = datetime.datetime.now()
    timestamp = now.strftime('%Y-%m-%d-%H-%M-%S')

    tags_list = [tag.strip() for tag in tags_raw.split('#') if tag.strip()]

    post_data = {
        "title": title,
        "published": timestamp,
        "tags": tags_list,
        "content": content
    }

    filename = os.path.join('posts', timestamp + '.json')

    try:
        with open(filename, 'w', encoding='ascii', errors='ignore') as f:
            json.dump(post_data, f, indent=4, ensure_ascii=True)

        print("Location: posts-show.py\n")

    except IOError as e:
        print("Content-Type: text/html; charset=ascii\n")
        print("<html><body><h1>Fehler beim Speichern</h1>")
        print("<p>Der Post konnte nicht gespeichert werden.</p>")
        print("<p>Details: " + str(e) + "</p>")
        print("</body></html>")