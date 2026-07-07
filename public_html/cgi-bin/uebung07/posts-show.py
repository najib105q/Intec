#!/usr/bin/env python3
# -*- coding: ascii -*-

import os
import json
import datetime
import cgitb
import html

try:
    from urllib.parse import quote_plus
except ImportError:
    from urllib import quote_plus

cgitb.enable()

print("Content-Type: text/html; charset=ascii\n\n")

print("""
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="ASCII">
    <title>Mein Blog</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #333;
            color: #eee;
            margin: 0;
            padding: 2em;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: #fff;
            margin-bottom: 1.5em;
        }
        .post {
            background-color: #f4f4f4;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1.5em;
            margin-bottom: 1.5em;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .post h2 {
            margin-top: 0;
            margin-bottom: 0.2em;
            font-size: 1.8em;
        }
        .post .timestamp {
            font-size: 0.9em;
            color: #e67e22;
            margin-bottom: 1em;
        }
        .post .content {
            margin-bottom: 1em;
            line-height: 1.6;
        }
        .post .tags a {
            text-decoration: none;
            color: #3498db;
            margin-right: 0.5em;
            font-weight: bold;
        }
        .post .tags a:hover {
            text-decoration: underline;
        }
        .footer-links {
            text-align: center;
            margin-top: 2em;
        }
        .footer-links a {
            display: inline-block;
            padding: 0.8em 1.5em;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .footer-links a:hover {
            background-color: #0056b3;
        }
        .error {
            color: #e74c3c;
            background-color: #2c0000;
            padding: 1em;
            border: 1px solid #e74c3c;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Mein Blog</h1>
""")

POSTS_DIR = 'posts'
posts_list = []

if not os.path.isdir(POSTS_DIR):
    print("<div class='error'>Fehler: Das Verzeichnis 'posts' wurde nicht gefunden.</div>")
else:
    try:
        filenames = sorted(os.listdir(POSTS_DIR), reverse=True)
    except OSError:
        filenames = []
        print("<div class='error'>Fehler: Das Verzeichnis 'posts' konnte nicht gelesen werden.</div>")

    for filename in filenames:
        if filename.endswith('.json'):
            filepath = os.path.join(POSTS_DIR, filename)
            try:
                with open(filepath, 'r', encoding='utf-8') as f:
                    post_data = json.load(f)
                    posts_list.append(post_data)
            except:
                continue

if not posts_list and os.path.isdir(POSTS_DIR):
    print("<p>Es wurden noch keine Beitraege erstellt.</p>")

for post in posts_list:
    display_date = "Datum unbekannt"
    try:
        dt_object = datetime.datetime.strptime(post.get('published', ''), '%Y-%m-%d-%H-%M-%S')
        display_date = dt_object.strftime('%d.%m.%Y, %H:%M Uhr')
    except:
        pass

    print("<div class='post'>")
    print("<h2>" + html.escape(post.get('title', 'Ohne Titel')) + "</h2>")
    print("<div class='timestamp'>" + display_date + "</div>")
    print("<div class='content'>" + html.escape(post.get('content', '')).replace('\\n', '<br>') + "</div>")

    if post.get('tags'):
        print("<div class='tags'>")
        for tag in post.get('tags', []):
            encoded_tag = quote_plus(tag)
            print('<a href="tags-show.py?tag=' + encoded_tag + '">#' + html.escape(tag) + '</a>')
        print("</div>")

    print("</div>")

print("""
    <div class="footer-links">
        <a href="posts-create.py">Post hinzufuegen</a>
    </div>
</div>
</body>
</html>
""")