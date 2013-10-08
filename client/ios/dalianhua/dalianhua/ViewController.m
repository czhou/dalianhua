//
//  ViewController.m
//  dalianhua
//
//  Created by Jack on 7/10/13.
//  Copyright (c) 2013 Salmonapps.com. All rights reserved.
//

#import "ViewController.h"
#import "Question.h"
#import "MBProgressHUD.h"

@interface ViewController ()

@end

@implementation ViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    MBProgressHUD *hud = [MBProgressHUD showHUDAddedTo:self.view animated:YES];
    hud.labelText = @"大连话准备中";
    
    for (int i=0; i<5; i++) {
        NSData *archivedData = [NSKeyedArchiver archivedDataWithRootObject: skipButton];
        UIButton *ans = [NSKeyedUnarchiver unarchiveObjectWithData: archivedData];
        ans.frame = CGRectMake(skipButton.frame.origin.x, 150 + i*ans.frame.size.height, skipButton.frame.size.width, skipButton.frame.size.height);
        [ans addTarget:self action:@selector(tapAnswer:) forControlEvents:UIControlEventTouchUpInside];
        ans.tag = 1000 + i;
        ans.hidden = YES;
        [self.view addSubview:ans];
    }
	
    
    [Question next:^(Question *question, NSError *error) {
        
        self.current = question;
        [self render];
        
        [MBProgressHUD hideAllHUDsForView:self.view animated:YES];
    }];
    
}

- (void)render {
    //题面
    textView.text = self.current.question;
    
    //隐藏所有button
    for (int i=0; i<5; i++) {
        int tag = 1000 + i;
        UIView *view = [self.view viewWithTag:tag];
        view.hidden = YES;
    }
    
    //答案
    [self.current.answers enumerateObjectsUsingBlock:^(id obj, NSUInteger idx, BOOL *stop) {
        
        NSString *title = [obj objectForKey:@"content"];
        int tag = 1000 + idx;
        UIButton *btn = (UIButton *)[self.view viewWithTag:tag];
        [btn setTitle:title forState:UIControlStateNormal];
        btn.hidden = NO;

    }];
    
}

- (void)tapAnswer:(id)sender {
    int tag = ((UIView *)sender).tag;
    int idx = tag - 1000;   //TODO 这个1000要define一下

    NSDictionary *answer = [self.current.answers objectAtIndex:idx];
    if (answer) {
        BOOL correct = [[answer objectForKey:@"correct"] boolValue];
        MBProgressHUD *hud = [MBProgressHUD showHUDAddedTo:self.view animated:YES];
        [hud setMinShowTime:1];
        if (correct) {
            hud.labelText = @"答对了，下一题准备中";
            [self.current correct];
            [self nextQuestion];
        }else {
            [hud setMode:MBProgressHUDModeText];
            hud.labelText = @"错了";
            [hud hide:YES];
        }
    }
}

- (IBAction)tapSkip:(id)sender {
    MBProgressHUD *hud = [MBProgressHUD showHUDAddedTo:self.view animated:YES];
    hud.labelText = @"下一题准备中";
    [self nextQuestion];
}

- (void)nextQuestion {
    [Question next:^(Question *question, NSError *error) {
        self.current = question;
        [self render];
        
        [MBProgressHUD hideAllHUDsForView:self.view animated:YES];
    }];
}

- (IBAction)tapPlay:(id)sender {
    
    if (!self.current.audio_url) {
        return;
    }
    if (!_speaker)
    {
        _speaker = [[MPMoviePlayerController alloc] init];
    }
    
    [_speaker stop];
    [_speaker setContentURL:[NSURL URLWithString:self.current.audio_url]];
    //_speaker.delegate = self;
    [_speaker play];
    
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
