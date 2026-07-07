#!/usr/bin/env python3
import random
import cgi
import cgitb

cgitb.enable()

print("Content-Type: text/html; charset=utf-8\n")

def generate_gallery_html():
    possible_counts = [i for i in range(3, 22) if i % 3 == 0]
    num_images = random.choice(possible_counts)
    
    html_content = f"""<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bildergalerie</title>
    <style>
        body {{
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f0f0f0;
            color: #333;
        }}
        .header-text {{
            text-align: center;
            margin-bottom: 30px;
        }}
        .header-text h1 {{
            color: #444;
        }}
        .gallery-container {{
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            padding: 15px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }}
        .gallery-container img {{
            width: 100%;
            height: auto;
            display: block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: transform 0.2s ease-in-out;
        }}
        .gallery-container img:hover {{
            transform: scale(1.03);
        }}
        @media (max-width: 900px) {{
            .gallery-container {{
                grid-template-columns: repeat(2, 1fr);
            }}
        }}
        @media (max-width: 600px) {{
            .gallery-container {{
                grid-template-columns: 1fr;
            }}
        }}
        footer {{
            text-align:center;
            margin-top:30px;
            padding-top:15px;
            border-top:1px solid #ddd;
            font-size:0.9em;
            color:#777;
        }}
    </style>
</head>
<body>
    <div class="header-text">
        <h1>Zuf&auml;llige Bildergalerie</h1>
        <p>Es werden {num_images} Bilder angezeigt.</p>
    </div>
    <div class="gallery-container">
"""

    for i in range(num_images):
        seed = f"uni_gallery_{random.randint(1, 100000)}_{i+1}"
        image_url = f"https://picsum.photos/seed/{seed}/800/600"
        alt_text = f"Zufallsbild {i+1}"
        html_content += f'        <img src="{image_url}" alt="{alt_text}">\n'
        
    html_content += """    </div>
</body>
</html>
"""
    return html_content

print(generate_gallery_html())