import time
import unittest
from webhook import valid_payload


class DeploymentRequestTests(unittest.TestCase):
    def setUp(self):
        self.now = int(time.time())
        self.payload = {'repository': 'flowsee-org/flowsee-main', 'ref': 'refs/heads/main',
                        'sha': 'a' * 40, 'issued_at': self.now}

    def test_current_main_request(self):
        self.assertTrue(valid_payload(self.payload, self.now))

    def test_wrong_repository_branch_commit_or_time_rejected(self):
        for key, value in [('repository', 'other/repo'), ('ref', 'refs/heads/feature'),
                           ('sha', 'main; arbitrary-command'), ('issued_at', self.now - 301),
                           ('issued_at', self.now + 301), ('issued_at', True)]:
            with self.subTest(key=key, value=value):
                self.assertFalse(valid_payload(dict(self.payload, **{key: value}), self.now))

    def test_non_object_rejected(self):
        self.assertFalse(valid_payload([], self.now))
