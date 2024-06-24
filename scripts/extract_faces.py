import json;
import sys;
from deepface import DeepFace;

try:
    result = DeepFace.extract_faces(
        img_path = "{{img_path}}",
        target_size={{target_size}},
        enforce_detection={{enforce_detection}},
        anti_spoofing={{anti_spoofing}},
        detector_backend="{{detector_backend}}",
        align={{align}},
        grayscale={{grayscale}},
    );

    print(json.dumps(result, default=str))
except ValueError as e:
    print(json.dumps({"error": str(e)}), file=sys.stderr)
