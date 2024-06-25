import sys
import pgpy

def encrypt_message(pubkey_text, message):
    pubkey = pgpy.PGPKey()
    pubkey.parse(pubkey_text)
    encrypted_message = pubkey.encrypt(pgpy.PGPMessage.new(message))
    return str(encrypted_message)

if __name__ == "__main__":
    pubkey_text = sys.argv[1]
    message = sys.argv[2]
    print(encrypt_message(pubkey_text, message))
