import json;
from deepface import DeepFace;

print(json.dumps(DeepFace.__version__, default=str))
