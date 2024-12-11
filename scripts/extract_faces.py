import sys;
import json;
from deepface import DeepFace;

try:
    result = DeepFace.extract_faces(
        img_path = "{{img_path}}",
        detector_backend = "{{detector_backend}}",
        enforce_detection = {{enforce_detection}},
        align = {{align}},
        expand_percentage = {{expand_percentage}},
        grayscale = {{grayscale}},
        color_face = "{{color_face}}",
        normalize_face = {{normalize_face}},
        anti_spoofing = {{anti_spoofing}},
    );

    print(json.dumps(result, default=str))
except ValueError as e:
    print(json.dumps({"error": str(e)}), file=sys.stderr)
