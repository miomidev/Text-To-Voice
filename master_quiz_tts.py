"""
Master Quiz TTS Helper Script
Reads config from a JSON file to avoid Windows shell escaping issues with % character.
Usage: python master_quiz_tts.py <config_json_path>
"""
import sys
import json
import asyncio
import edge_tts


async def generate(text: str, voice: str, rate: str, pitch: str, output: str) -> None:
    communicate = edge_tts.Communicate(text, voice, rate=rate, pitch=pitch)
    await communicate.save(output)


def main():
    if len(sys.argv) < 2:
        print("Usage: python master_quiz_tts.py <config_json_path>", file=sys.stderr)
        sys.exit(1)

    config_path = sys.argv[1]

    try:
        # Use utf-8-sig to handle BOM written by Windows PowerShell/Notepad
        with open(config_path, "r", encoding="utf-8-sig") as f:
            config = json.load(f)
    except Exception as e:
        print(f"Failed to read config: {e}", file=sys.stderr)
        sys.exit(1)

    text   = config.get("text", "")
    voice  = config.get("voice", "id-ID-ArdiNeural")
    rate   = config.get("rate", "+0%")
    pitch  = config.get("pitch", "+0Hz")
    output = config.get("output", "")

    if not text or not output:
        print("Config must include 'text' and 'output'.", file=sys.stderr)
        sys.exit(1)

    asyncio.run(generate(text, voice, rate, pitch, output))
    print("OK")


if __name__ == "__main__":
    main()
