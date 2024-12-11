import sys;
import json;
from deepface import DeepFace;

try:
    result = DeepFace.represent(
        img_path = "{{img_path}}",
        model_name = "{{model_name}}",
        enforce_detection = {{enforce_detection}},
        detector_backend = "{{detector_backend}}",
        align = {{align}},
        expand_percentage = {{expand_percentage}},
        normalization = "{{normalization}}",
        anti_spoofing = "{{anti_spoofing}}",
        max_faces = {{max_faces}},
    );

    print(json.dumps(result, default=str))
except ValueError as e:
    print(json.dumps({"error": str(e)}), file=sys.stderr)

