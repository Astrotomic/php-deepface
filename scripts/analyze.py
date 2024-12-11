import sys;
import json;
from deepface import DeepFace;

try:
    result = DeepFace.analyze(
        img_path = "{{img_path}}",
        actions = {{actions}},
        enforce_detection = {{enforce_detection}},
        detector_backend = "{{detector_backend}}",
        align = {{align}},
        expand_percentage = {{expand_percentage}},
        silent = {{silent}},
        anti_spoofing = {{anti_spoofing}},
    );

    print(json.dumps(result, default=str))
except ValueError as e:
    print(json.dumps({"error": str(e)}), file=sys.stderr)
