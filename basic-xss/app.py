from flask import Flask, request, render_template_string

app = Flask(__name__)

FLAG = "FLAG{basic_xss_pwned}"

@app.route("/", methods=["GET", "POST"])
def home():
    comment = request.args.get("comment", "")

    html_content = f"""
    <!DOCTYPE html>
    <html>
    <head>
        <title>Basic XSS Challenge</title>
    </head>
    <body>
        <h2>Basic XSS Challenge</h2>
        <p>Enter a comment and try to find the flag!</p>
        <form method="GET">
            <input type="text" name="comment" placeholder="Enter your comment">
            <button type="submit">Submit</button>
        </form>
        <h3>Output:</h3>
        <p>{comment}</p>
    </body>
    </html>
    """
    
    return render_template_string(html_content)

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000)
