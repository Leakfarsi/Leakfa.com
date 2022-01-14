import hashlib
import requests
import sys


if (sys.version_info > (3, 0)):
    pass
else:
     # Python 2 code in this block
     def input(x):
         return raw_input(x)

sha1 = lambda x: hashlib.sha1(x.encode("utf-8")).hexdigest()

class PoW():
    def __init__(self, data, bit = "a", diff = 5):
        self._data = data
        self._nonce = {
            "data": 0,
            "valid": False
        }
        self._bit = bit
        self._diff = 5
        self._sha1 = lambda x: hashlib.sha1(x.encode("utf-8")).hexdigest()

    @property
    def data(self):
        return self._data

    @property
    def nonce(self):
        if self._nonce["valid"]:
            return self._nonce["data"]
        else:
            while not self._nonce["valid"]:
                if self._sha1(self._data + str(self._nonce["data"]))[:self._diff] == self._bit * self._diff:
                    self._nonce["valid"] = True
                    return self._nonce["data"]
                else:
                    self._nonce["data"] += 1
    @property
    def result_hash(self):
        return self._sha1(self._data + str(self._nonce["data"]))

if __name__ == "__main__":

    org_input = input("Please input your Mobile or Email address: ")

    test = PoW(sha1(org_input))
    print("Original data: ", org_input)
    print("data: ", test.data)
    print("nonce: ", test.nonce)
    print("hash: ", test.result_hash)

    r = requests.get('https://leakfa.com/api/search.php?mode=pow&hash={}&nonce={}'.format(test.data, test.nonce))
    print("\nresult: ", r.json())
