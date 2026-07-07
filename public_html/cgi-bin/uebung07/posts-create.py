#!/usr/bin/env python3
# -*- coding: ascii -*-

print("Content-Type: text/html; charset=ascii\n\n")

print("""
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="ASCII">
    <title>Neuen Blog-Post erstellen</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #333;
            color: #eee;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #444;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 500px;
        }
        h1 {
            text-align: center;
            color: #fff;
        }
        label {
            display: block;
            margin-top: 1em;
            margin-bottom: 0.5em;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 0.5em;
            border: 1px solid #666;
            background-color: #555;
            color: #eee;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            height: 150px;
            resize: vertical;
        }
        input[type="submit"] {
            width: 100%;
            padding: 0.7em;
            margin-top: 1.5em;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Post hinzufuegen</h1>
        <form action="posts-store.py" method="post">
            <label for="title">Titel</label>
            <input type="text" id="title" name="title">

            <label for="content">Content</label>
            <textarea id="content" name="content"></textarea>

            <label for="tags">Tags</label>
            <input type="text" id="tags" name="tags" placeholder="#tag1 #tag2 #usw">

            <input type="submit" value="Speichern">
        </form>
    </div>
</body>
</html>
""")
