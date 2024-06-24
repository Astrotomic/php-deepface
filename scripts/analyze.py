import json;
import sys;
from deepface import DeepFace;

try:
    result = DeepFace.analyze(
        img_path = "{{img_path}}",
        actions={{actions}},
        enforce_detection={{enforce_detection}},
        anti_spoofing={{anti_spoofing}},
        detector_backend="{{detector_backend}}",
        align={{align}},
        silent={{silent}},
    );
    print(json.dumps(result, default=str))
except ValueError as e:
    print(json.dumps({"error": str(e)}), file=sys.stderr)
