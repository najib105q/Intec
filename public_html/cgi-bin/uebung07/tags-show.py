#!/usr/bin/env python3
# -*- coding: ascii -*-

import os
import json
import datetime
import cgi
import cgitb
import html

try:
    from urllib.parse import quote_plus
except ImportError:
    from urllib import quote_plus

cgitb.enable()

POSTS_DIR = 'posts'

def load_all_posts():
    posts_list = []
    if not os.path.isdir(POSTS_DIR):
        return posts_list
    try:
        filenames = sorted(os.listdir(POSTS_DIR), reverse=True)
    except OSError:
        return []
    for filename in filenames:
        if filename.endswith('.json'):
            filepath = os.path.join(POSTS_DIR, filename)
            try:
                with open(filepath, 'r', encoding='ascii', errors='ignore') as f:
                    posts_list.append(json.load(f))
            except:
                continue
    return posts_list

def print_html_head(title):
    print("Content-Type: text/html; charset=ascii\n\n")
    print("""
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="ASCII">
    <title>""" + html.escape(title) + """</title>
    <style>
        body { font-family: sans-serif; background-color: #333; color: #eee; margin: 0; padding: 2em; }
        .container { max-width: 800px; margin: 0 auto; }
        h1 { text-align: center; color: #fff; margin-bottom: 1.5em; }
        .post { background-color: #f4f4f4; color: #333; border-radius: 8px; padding: 1.5em; margin-bottom: 1.5em; box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
        .post h2 { margin-top: 0; margin-bottom: 0.2em; font-size: 1.8em; }
        .post .timestamp { font-size: 0.9em; color: #e67e22; margin-bottom: 1em; }
        .post .content { margin-bottom: 1em; line-height: 1.6; }
        .post .tags a, .tag-list a { text-decoration: none; color: #3498db; font-weight: bold; }
        .post .tags a:hover, .tag-list a:hover { text-decoration: underline; }
        .post .tags a { margin-right: 0.5em; }
        .tag-list { background-color: #444; border: 1px solid #555; padding: 1.5em; border-radius: 8px; text-align: center; }
        .tag-list a { display: inline-block; margin: 0.5em; font-size: 1.2em; }
        .footer-links { text-align: center; margin-top: 2em; }
        .footer-links a { margin: 0 1em; display: inline-block; padding: 0.8em 1.5em; background-color: #555; color: white; text-decoration: none; border-radius: 4px; }
        .footer-links a:hover { background-color: #666; }
        .error { color: #e74c3c; background-color: #2c0000; padding: 1em; border-radius: 5px; }
    </style>
</head>
<body>
<div class="container">
    """)

def print_html_footer():
    print("""
    <div class="footer-links">
        <a href="posts-create.py">Post hinzufuegen</a>
        <a href="tags-show.py">Tags anzeigen</a>
    </div>
</div>
</body>
</html>
    """)

def display_tag_list(all_posts):
    title = "Tags"
    print_html_head(title)
    print("<h1>" + title + "</h1>")
    all_tags = set()
    for post in all_posts:
        all_tags.update(post.get('tags', []))
    if not all_tags:
        print("<p>Es wurden noch keine Tags gefunden.</p>")
    else:
        sorted_tags = sorted(list(all_tags))
        print("<div class='tag-list'>")
        for tag in sorted_tags:
            encoded_tag = quote_plus(tag)
            print('<a href="tags-show.py?tag=' + encoded_tag + '">#' + html.escape(tag) + '</a>')
        print("</div>")
    print_html_footer()

def display_posts_for_tag(all_posts, tag):
    title = "#" + html.escape(tag)
    print_html_head(title)
    print("<h1>" + title + "</h1>")
    filtered_posts = [p for p in all_posts if tag in p.get('tags', [])]
    if not filtered_posts:
        print("<p>Keine Posts mit diesem Tag gefunden.</p>")
    else:
        for post in filtered_posts:
            display_date = "Datum unbekannt"
            try:
                dt_object = datetime.datetime.strptime(post.get('published', ''), '%Y-%m-%d-%H-%M-%S')
                display_date = dt_object.strftime('%d.%m.%Y, %H:%M Uhr')
            except:
                pass
            print("<div class='post'>")
            print("<h2>" + html.escape(post.get('title', 'Ohne Titel')) + "</h2>")
            print("<div class='timestamp'>" + display_date + "</div>")
            print("<div class='content'>" + html.escape(post.get('content', '')).replace('\n', '<br>') + "</div>")
            if post.get('tags'):
                print("<div class='tags'>")
                for t in post.get('tags', []):
                    encoded_tag = quote_plus(t)
                    print('<a href="tags-show.py?tag=' + encoded_tag + '">#' + html.escape(t) + '</a>')
                print("</div>")
            print("</div>")
    print_html_footer()

if __name__ == "__main__":
    form = cgi.FieldStorage()
    selected_tag = form.getvalue('tag')
    all_posts = load_all_posts()
    if selected_tag is None:
        display_tag_list(all_posts)
    else:
        display_posts_for_tag(all_posts, selected_tag)