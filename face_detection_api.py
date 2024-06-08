import os

import cv2
import dlib
import numpy as np
from flask import Flask, request, jsonify
from dotenv import load_dotenv

load_dotenv()  # take environment variables from .env.

app = Flask(__name__)

# Initialize dlib's face detector
detector = dlib.get_frontal_face_detector()


@app.route('/detect_faces', methods=['POST'])
def detect_faces():
    if 'image' not in request.files:
        return jsonify({'faces': 0}), 400

    file = request.files['image']
    if file.filename == '':
        return jsonify({'faces': 0}), 400

    # Read the image file as a numpy array
    np_image = np.frombuffer(file.read(), np.uint8)
    # Decode the image to OpenCV format
    img = cv2.imdecode(np_image, cv2.IMREAD_COLOR)

    # Perform face detection
    faces = detector(img, 1)

    return jsonify({'faces': len(faces)}), 200


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=os.environ.get("APP_PYTHON_PORT"))
